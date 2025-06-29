<?php

namespace App\Http\Controllers;

use App\Models\HomePageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomePageController extends Controller
{
    /**
     * Display the home page with dynamic content
     */
    public function index()
    {
        $content = HomePageContent::getAllActive();
        
        return view('home', compact('content'));
    }

    /**
     * Show the CMS interface for managing home page content
     */
    public function manage()
    {
        $content = HomePageContent::all()->keyBy('section');
        
        return view('admin.cms.home-page', compact('content'))->with('activePage', 'cms');
    }

    /**
     * Update hero section content
     */
    public function updateHero(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:500',
            'button_text' => 'required|string|max:100',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $hero = HomePageContent::firstOrCreate(['section' => 'hero']);
            
            $hero->title = $request->title;
            $hero->subtitle = $request->subtitle;
            $hero->button_text = $request->button_text;
            $hero->button_link = route('book-now');
            $hero->is_active = true;

            // Handle image upload to public/img directory
            if ($request->hasFile('hero_image')) {
                // Delete old image if exists
                if ($hero->image_path && file_exists(public_path(str_replace('/public', '', $hero->image_path)))) {
                    unlink(public_path(str_replace('/public', '', $hero->image_path)));
                }

                $image = $request->file('hero_image');
                $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = '/public/img/' . $imageName;
                
                // Move image to public/img directory
                $image->move(public_path('img'), $imageName);
                $hero->image_path = $imagePath;
            }

            $hero->save();

            return response()->json([
                'success' => true,
                'message' => 'Hero section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update hero section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update services section content
     */
    public function updateServices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_title' => 'required|string|max:255',
            'services' => 'required|array|min:1',
            'services.*.title' => 'required|string|max:255',
            'services.*.description' => 'required|string|max:500',
            'services.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'services.*.type' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $services = HomePageContent::firstOrCreate(['section' => 'services']);
            
            $services->title = $request->section_title;
            $services->is_active = true;

            $serviceCards = [];
            
            foreach ($request->services as $index => $serviceData) {
                $serviceCard = [
                    'title' => $serviceData['title'],
                    'description' => $serviceData['description'],
                    'type' => $serviceData['type'],
                    'link' => route('packages') . '?type=' . strtolower($serviceData['type'])
                ];

                // Handle image upload for each service to public/img directory
                if (isset($serviceData['image']) && $serviceData['image']) {
                    $image = $serviceData['image'];
                    $imageName = 'service_' . strtolower($serviceData['type']) . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $imagePath = '/public/img/' . $imageName;
                    
                    // Move image to public/img directory
                    $image->move(public_path('img'), $imageName);
                    $serviceCard['image_path'] = $imagePath;
                } else {
                    // Keep existing image if no new image uploaded
                    if (isset($services->service_cards[$index]['image_path'])) {
                        $existingPath = $services->service_cards[$index]['image_path'];
                        // Ensure the path is in the correct format
                        if (strpos($existingPath, '/public/img/') === 0) {
                            $serviceCard['image_path'] = $existingPath;
                        } else {
                            // Convert old format to new format
                            $serviceCard['image_path'] = '/public/img/' . basename($existingPath);
                        }
                    }
                }

                $serviceCards[] = $serviceCard;
            }

            $services->service_cards = $serviceCards;
            $services->save();

            return response()->json([
                'success' => true,
                'message' => 'Services section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update services section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update contact section content
     */
    public function updateContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_title' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:50',
            'contact_email' => 'required|email|max:255',
            'contact_address' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $contact = HomePageContent::firstOrCreate(['section' => 'contact']);
            
            $contact->title = $request->section_title;
            $contact->contact_phone = $request->contact_phone;
            $contact->contact_email = $request->contact_email;
            $contact->contact_address = $request->contact_address;
            $contact->is_active = true;
            $contact->save();

            return response()->json([
                'success' => true,
                'message' => 'Contact section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update contact section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update about section content
     */
    public function updateAbout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_title' => 'required|string|max:255',
            'description' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $about = HomePageContent::firstOrCreate(['section' => 'about']);
            
            $about->title = $request->section_title;
            $about->description = $request->description;
            $about->is_active = true;
            $about->save();

            return response()->json([
                'success' => true,
                'message' => 'About section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update about section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle section visibility
     */
    public function toggleSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section' => 'required|string|exists:home_page_contents,section'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $content = HomePageContent::where('section', $request->section)->first();
            $content->is_active = !$content->is_active;
            $content->save();

            return response()->json([
                'success' => true,
                'message' => ucfirst($request->section) . ' section ' . ($content->is_active ? 'activated' : 'deactivated') . ' successfully!',
                'is_active' => $content->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Manage services page content
     */
    public function manageServicesPage()
    {
        $content = HomePageContent::getAllActive();
        
        return view('admin.cms.services-page', compact('content'))->with('activePage', 'services-cms');
    }

    /**
     * Update services page hero section
     */
    public function updateServicesHero(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:500',
            'hero_button_text' => 'required|string|max:100',
            'hero_button_link' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $hero = HomePageContent::firstOrCreate(['section' => 'services_hero']);
            
            $hero->title = $request->hero_title;
            $hero->subtitle = $request->hero_subtitle;
            $hero->button_text = $request->hero_button_text;
            $hero->button_link = $request->hero_button_link;
            $hero->is_active = true;
            $hero->save();

            return response()->json([
                'success' => true,
                'message' => 'Services page hero section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update services page hero section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update services page main services section
     */
    public function updateServicesPageServices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'services' => 'required|array|min:1',
            'services.*.title' => 'required|string|max:255',
            'services.*.description' => 'required|string|max:1000',
            'services.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'services.*.type' => 'required|string|max:100',
            'services.*.features' => 'required|array|min:1',
            'services.*.features.*' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $services = HomePageContent::firstOrCreate(['section' => 'services_page_services']);
            $services->is_active = true;

            $serviceCards = [];
            
            foreach ($request->services as $index => $serviceData) {
                $serviceCard = [
                    'title' => $serviceData['title'],
                    'description' => $serviceData['description'],
                    'type' => $serviceData['type'],
                    'features' => $serviceData['features'],
                    'link' => route('packages') . '?type=' . strtolower($serviceData['type'])
                ];

                // Handle image upload for each service to public/img directory
                if (isset($serviceData['image']) && $serviceData['image']) {
                    // Delete old image if exists
                    if (isset($services->service_cards[$index]['image_path']) && file_exists(public_path($services->service_cards[$index]['image_path']))) {
                        unlink(public_path($services->service_cards[$index]['image_path']));
                    }

                    $image = $serviceData['image'];
                    $imageName = 'services_page_' . strtolower($serviceData['type']) . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $imagePath = '/public/img/' . $imageName;
                    
                    // Move image to public/img directory
                    $image->move(public_path('img'), $imageName);
                    $serviceCard['image_path'] = $imagePath;
                } else {
                    // Keep existing image if no new image uploaded
                    if (isset($services->service_cards[$index]['image_path'])) {
                        $existingPath = $services->service_cards[$index]['image_path'];
                        // Ensure the path is in the correct format
                        if (strpos($existingPath, '/public/img/') === 0) {
                            $serviceCard['image_path'] = $existingPath;
                        } else {
                            // Convert old format to new format
                            $serviceCard['image_path'] = '/public/img/' . basename($existingPath);
                        }
                    }
                }

                $serviceCards[] = $serviceCard;
            }

            $services->service_cards = $serviceCards;
            $services->save();

            return response()->json([
                'success' => true,
                'message' => 'Services page services section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update services page services section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update services page coming soon section
     */
    public function updateServicesComingSoon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coming_soon_title' => 'required|string|max:255',
            'coming_soon_subtitle' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $comingSoon = HomePageContent::firstOrCreate(['section' => 'services_coming_soon']);
            
            $comingSoon->title = $request->coming_soon_title;
            $comingSoon->subtitle = $request->coming_soon_subtitle;
            $comingSoon->is_active = true;
            $comingSoon->save();

            return response()->json([
                'success' => true,
                'message' => 'Services page coming soon section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update services page coming soon section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update services page why choose us section
     */
    public function updateServicesWhyChooseUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'why_choose_title' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $whyChoose = HomePageContent::firstOrCreate(['section' => 'services_why_choose']);
            
            $whyChoose->title = $request->why_choose_title;
            $whyChoose->is_active = true;
            $whyChoose->save();

            return response()->json([
                'success' => true,
                'message' => 'Services page why choose us section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update services page why choose us section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update services page CTA section
     */
    public function updateServicesCTA(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cta_title' => 'required|string|max:255',
            'cta_subtitle' => 'required|string|max:500',
            'cta_primary_button_text' => 'required|string|max:100',
            'cta_primary_button_link' => 'required|string|max:255',
            'cta_secondary_button_text' => 'required|string|max:100',
            'cta_secondary_button_link' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $cta = HomePageContent::firstOrCreate(['section' => 'services_cta']);
            
            $cta->title = $request->cta_title;
            $cta->subtitle = $request->cta_subtitle;
            $cta->button_text = $request->cta_primary_button_text;
            $cta->button_link = $request->cta_primary_button_link;
            $cta->service_cards = [
                'secondary_button_text' => $request->cta_secondary_button_text,
                'secondary_button_link' => $request->cta_secondary_button_link
            ];
            $cta->is_active = true;
            $cta->save();

            return response()->json([
                'success' => true,
                'message' => 'Services page CTA section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update services page CTA section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Manage packages page CMS
     */
    public function managePackagesPage()
    {
        $content = [
            'packages_hero' => HomePageContent::where('section', 'packages_hero')->first(),
            'packages_wedding' => HomePageContent::where('section', 'packages_wedding')->first(),
            'packages_birthday' => HomePageContent::where('section', 'packages_birthday')->first(),
            'packages_debut' => HomePageContent::where('section', 'packages_debut')->first(),
            'packages_baptism' => HomePageContent::where('section', 'packages_baptism')->first(),
        ];

        return view('admin.cms.packages-page', compact('content'))->with('activePage', 'packages-cms');
    }

    /**
     * Update packages page hero section
     */
    public function updatePackagesHero(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $hero = HomePageContent::firstOrCreate(['section' => 'packages_hero']);
            
            $hero->title = $request->hero_title;
            $hero->subtitle = $request->hero_subtitle;
            $hero->is_active = true;
            $hero->save();

            return response()->json([
                'success' => true,
                'message' => 'Packages page hero section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update packages page hero section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update packages for a specific type
     */
    public function updatePackagesType(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'packages' => 'required|array|min:1',
            'packages.*.name' => 'required|string|max:255',
            'packages.*.price' => 'required|string|max:50',
            'packages.*.features' => 'required|array|min:1',
            'packages.*.features.*' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $packages = HomePageContent::firstOrCreate(['section' => 'packages_' . $type]);
            
            $packages->service_cards = $request->packages;
            $packages->is_active = true;
            $packages->save();

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' packages updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update ' . $type . ' packages: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display packages page
     */
    public function packages(Request $request)
    {
        $type = $request->get('type', 'wedding');
        
        // Get CMS data for packages
        $packagesData = [];
        
        $weddingPackages = HomePageContent::where('section', 'packages_wedding')->first();
        $birthdayPackages = HomePageContent::where('section', 'packages_birthday')->first();
        $debutPackages = HomePageContent::where('section', 'packages_debut')->first();
        $baptismPackages = HomePageContent::where('section', 'packages_baptism')->first();
        
        // Default packages if CMS data doesn't exist
        $defaultWeddingPackages = [
            ['name' => 'Classic Wedding', 'price' => '₱50,000', 'features' => ['Venue coordination', 'Basic decor', 'On-the-day coordination']],
            ['name' => 'Elegant Wedding', 'price' => '₱100,000', 'features' => ['Premium venue', 'Full floral design', 'Photo & video coverage']],
            ['name' => 'Luxury Wedding', 'price' => '₱200,000', 'features' => ['5-star venue', 'Luxury styling', 'Live band & emcee']],
        ];
        
        $defaultBirthdayPackages = [
            ['name' => 'Kids Party', 'price' => '₱15,000', 'features' => ['Theme decor', 'Party host', 'Games & prizes']],
            ['name' => 'Teen Bash', 'price' => '₱25,000', 'features' => ['DJ & lights', 'Photo booth', 'Custom cake']],
            ['name' => 'Milestone Birthday', 'price' => '₱40,000', 'features' => ['Venue rental', 'Catering', 'Live entertainment']],
        ];
        
        $defaultDebutPackages = [
            ['name' => 'Classic Debut', 'price' => '₱35,000', 'features' => ['Venue coordination', 'Basic decor', 'On-the-day coordination']],
            ['name' => 'Elegant Debut', 'price' => '₱70,000', 'features' => ['Premium venue', 'Full floral design', 'Photo & video coverage']],
            ['name' => 'Luxury Debut', 'price' => '₱150,000', 'features' => ['5-star venue', 'Luxury styling', 'Live band & emcee']],
        ];
        
        $defaultBaptismPackages = [
            ['name' => 'Simple Baptism', 'price' => '₱20,000', 'features' => ['Venue coordination', 'Basic decor', 'On-the-day coordination']],
            ['name' => 'Elegant Baptism', 'price' => '₱45,000', 'features' => ['Premium venue', 'Full floral design', 'Photo & video coverage']],
            ['name' => 'Luxury Baptism', 'price' => '₱100,000', 'features' => ['5-star venue', 'Luxury styling', 'Live band & emcee']],
        ];
        
        $packagesData = [
            'wedding' => $weddingPackages && $weddingPackages->is_active ? $weddingPackages->service_cards : $defaultWeddingPackages,
            'birthday' => $birthdayPackages && $birthdayPackages->is_active ? $birthdayPackages->service_cards : $defaultBirthdayPackages,
            'debut' => $debutPackages && $debutPackages->is_active ? $debutPackages->service_cards : $defaultDebutPackages,
            'baptism' => $baptismPackages && $baptismPackages->is_active ? $baptismPackages->service_cards : $defaultBaptismPackages,
        ];
        
        return view('packages', compact('packagesData', 'type'));
    }

    /**
     * Manage gallery page CMS
     */
    public function manageGalleryPage()
    {
        $content = [
            'gallery_hero' => HomePageContent::where('section', 'gallery_hero')->first(),
            'gallery_cta' => HomePageContent::where('section', 'gallery_cta')->first(),
            'gallery_images' => HomePageContent::where('section', 'gallery_images')->first(),
        ];

        return view('admin.cms.gallery-page', compact('content'))->with('activePage', 'gallery-cms');
    }

    /**
     * Update gallery page hero section
     */
    public function updateGalleryHero(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $hero = HomePageContent::firstOrCreate(['section' => 'gallery_hero']);
            
            $hero->title = $request->hero_title;
            $hero->subtitle = $request->hero_subtitle;
            $hero->is_active = true;
            $hero->save();

            return response()->json([
                'success' => true,
                'message' => 'Gallery page hero section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update gallery page hero section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update gallery images
     */
    public function updateGalleryImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|array|min:1',
            'images.*.title' => 'required|string|max:255',
            'images.*.description' => 'required|string|max:500',
            'images.*.category' => 'required|string|in:wedding,birthday,debut,baptism',
            'images.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*.alt_text' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $galleryImages = HomePageContent::firstOrCreate(['section' => 'gallery_images']);
            $galleryImages->is_active = true;

            $images = [];
            
            foreach ($request->images as $index => $imageData) {
                $imageItem = [
                    'title' => $imageData['title'],
                    'description' => $imageData['description'],
                    'category' => $imageData['category'],
                    'alt_text' => $imageData['alt_text']
                ];

                // Handle image upload
                if (isset($imageData['image']) && $imageData['image']) {
                    // Delete old image if exists
                    if (isset($galleryImages->service_cards[$index]['image_path']) && file_exists(public_path($galleryImages->service_cards[$index]['image_path']))) {
                        unlink(public_path($galleryImages->service_cards[$index]['image_path']));
                    }

                    $image = $imageData['image'];
                    $imageName = 'gallery_' . $imageData['category'] . '_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $imagePath = '/public/img/' . $imageName;
                    
                    // Move image to public/img directory
                    $image->move(public_path('img'), $imageName);
                    $imageItem['image_path'] = $imagePath;
                } else {
                    // Keep existing image if no new image uploaded
                    if (isset($galleryImages->service_cards[$index]['image_path'])) {
                        $existingPath = $galleryImages->service_cards[$index]['image_path'];
                        if (strpos($existingPath, '/public/img/') === 0) {
                            $imageItem['image_path'] = $existingPath;
                        } else {
                            $imageItem['image_path'] = '/public/img/' . basename($existingPath);
                        }
                    }
                }

                $images[] = $imageItem;
            }

            $galleryImages->service_cards = $images;
            $galleryImages->save();

            return response()->json([
                'success' => true,
                'message' => 'Gallery images updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update gallery images: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update gallery page CTA section
     */
    public function updateGalleryCTA(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cta_title' => 'required|string|max:255',
            'cta_subtitle' => 'required|string|max:500',
            'cta_primary_button_text' => 'required|string|max:100',
            'cta_primary_button_link' => 'required|string|max:255',
            'cta_secondary_button_text' => 'required|string|max:100',
            'cta_secondary_button_link' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $cta = HomePageContent::firstOrCreate(['section' => 'gallery_cta']);
            
            $cta->title = $request->cta_title;
            $cta->subtitle = $request->cta_subtitle;
            $cta->button_text = $request->cta_primary_button_text;
            $cta->button_link = $request->cta_primary_button_link;
            $cta->service_cards = [
                'secondary_button_text' => $request->cta_secondary_button_text,
                'secondary_button_link' => $request->cta_secondary_button_link
            ];
            $cta->is_active = true;
            $cta->save();

            return response()->json([
                'success' => true,
                'message' => 'Gallery page CTA section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update gallery page CTA section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display gallery page
     */
    public function gallery()
    {
        // Get CMS data for gallery
        $galleryHero = HomePageContent::where('section', 'gallery_hero')->first();
        $galleryImages = HomePageContent::where('section', 'gallery_images')->first();
        $galleryCTA = HomePageContent::where('section', 'gallery_cta')->first();
        
        // Default content if CMS data doesn't exist
        $defaultGalleryImages = [
            [
                'title' => 'Elegant Wedding',
                'description' => 'Beautiful outdoor ceremony',
                'category' => 'wedding',
                'alt_text' => 'Wedding Celebration',
                'image_path' => '/public/img/wedding.webp'
            ],
            [
                'title' => 'Wedding Reception',
                'description' => 'Magical evening celebration',
                'category' => 'wedding',
                'alt_text' => 'Wedding Reception',
                'image_path' => '/public/img/wedding.png'
            ],
            [
                'title' => 'Birthday Celebration',
                'description' => 'Fun and colorful party',
                'category' => 'birthday',
                'alt_text' => 'Birthday Party',
                'image_path' => '/public/img/birthday.jpg'
            ],
            [
                'title' => '18th Debut',
                'description' => 'Elegant coming-of-age celebration',
                'category' => 'debut',
                'alt_text' => 'Debut Celebration',
                'image_path' => '/public/img/debut.webp'
            ],
            [
                'title' => 'Baptism Ceremony',
                'description' => 'Sacred family celebration',
                'category' => 'baptism',
                'alt_text' => 'Baptism Ceremony',
                'image_path' => '/public/img/baptism.jpg'
            ],
            [
                'title' => 'Wedding Transportation',
                'description' => 'Luxury wedding car service',
                'category' => 'wedding',
                'alt_text' => 'Wedding Transportation',
                'image_path' => '/public/img/car1.jpg'
            ]
        ];
        
        $galleryData = [
            'hero' => [
                'title' => $galleryHero && $galleryHero->is_active ? $galleryHero->title : 'Our Event Gallery',
                'subtitle' => $galleryHero && $galleryHero->is_active ? $galleryHero->subtitle : 'Explore our collection of beautiful events and celebrations we\'ve helped create'
            ],
            'images' => $galleryImages && $galleryImages->is_active ? array_map(function($image) {
                return [
                    'title' => $image['title'] ?? 'Gallery Image',
                    'description' => $image['description'] ?? 'Beautiful event',
                    'category' => $image['category'] ?? 'wedding',
                    'alt_text' => $image['alt_text'] ?? 'Gallery Image',
                    'image_path' => $image['image_path'] ?? null
                ];
            }, $galleryImages->service_cards) : $defaultGalleryImages,
            'cta' => [
                'title' => $galleryCTA && $galleryCTA->is_active ? $galleryCTA->title : 'Inspired by Our Work?',
                'subtitle' => $galleryCTA && $galleryCTA->is_active ? $galleryCTA->subtitle : 'Let\'s create your own beautiful memories together',
                'primary_button_text' => $galleryCTA && $galleryCTA->is_active ? $galleryCTA->button_text : 'Start Planning Your Event',
                'primary_button_link' => $galleryCTA && $galleryCTA->is_active ? $galleryCTA->button_link : route('book-now'),
                'secondary_button_text' => $galleryCTA && $galleryCTA->is_active && $galleryCTA->service_cards && isset($galleryCTA->service_cards['secondary_button_text']) ? $galleryCTA->service_cards['secondary_button_text'] : 'Contact Us',
                'secondary_button_link' => $galleryCTA && $galleryCTA->is_active && $galleryCTA->service_cards && isset($galleryCTA->service_cards['secondary_button_link']) ? $galleryCTA->service_cards['secondary_button_link'] : route('home') . '#contact'
            ]
        ];
        
        return view('gallery', compact('galleryData'));
    }

    /**
     * Manage about page content
     */
    public function manageAboutPage()
    {
        $content = HomePageContent::getAllActive();
        
        return view('admin.cms.about-page', compact('content'))->with('activePage', 'about-cms');
    }

    /**
     * Update about page hero section
     */
    public function updateAboutHero(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $hero = HomePageContent::firstOrCreate(['section' => 'about_hero']);
            
            $hero->title = $request->hero_title;
            $hero->subtitle = $request->hero_subtitle;
            $hero->is_active = true;
            $hero->save();

            return response()->json([
                'success' => true,
                'message' => 'About page hero section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update about page hero section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update about page story section
     */
    public function updateAboutStory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'story_title' => 'required|string|max:255',
            'story_content' => 'required|string|max:2000',
            'story_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $story = HomePageContent::firstOrCreate(['section' => 'about_story']);
            
            $story->title = $request->story_title;
            $story->description = $request->story_content;
            $story->is_active = true;

            // Handle image upload
            if ($request->hasFile('story_image')) {
                // Delete old image if exists
                if ($story->image_path && file_exists(public_path($story->image_path))) {
                    unlink(public_path($story->image_path));
                }

                $image = $request->file('story_image');
                $imageName = 'about_story_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = '/public/img/' . $imageName;
                
                // Move image to public/img directory
                $image->move(public_path('img'), $imageName);
                $story->image_path = $imagePath;
            }

            $story->save();

            return response()->json([
                'success' => true,
                'message' => 'About page story section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update about page story section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update about page mission and vision section
     */
    public function updateAboutMissionVision(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mission_title' => 'required|string|max:255',
            'mission_content' => 'required|string|max:1000',
            'vision_title' => 'required|string|max:255',
            'vision_content' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $missionVision = HomePageContent::firstOrCreate(['section' => 'about_mission_vision']);
            
            $missionVision->service_cards = [
                'mission_title' => $request->mission_title,
                'mission_content' => $request->mission_content,
                'vision_title' => $request->vision_title,
                'vision_content' => $request->vision_content
            ];
            $missionVision->is_active = true;
            $missionVision->save();

            return response()->json([
                'success' => true,
                'message' => 'About page mission and vision updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update about page mission and vision: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update about page values section
     */
    public function updateAboutValues(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'values_title' => 'required|string|max:255',
            'values' => 'required|array|min:1',
            'values.*.title' => 'required|string|max:255',
            'values.*.description' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $values = HomePageContent::firstOrCreate(['section' => 'about_values']);
            
            $values->title = $request->values_title;
            $values->service_cards = $request->values;
            $values->is_active = true;
            $values->save();

            return response()->json([
                'success' => true,
                'message' => 'About page values updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update about page values: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update about page stats section
     */
    public function updateAboutStats(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stats' => 'required|array|min:1',
            'stats.*.number' => 'required|string|max:50',
            'stats.*.label' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $stats = HomePageContent::firstOrCreate(['section' => 'about_stats']);
            
            $stats->service_cards = $request->stats;
            $stats->is_active = true;
            $stats->save();

            return response()->json([
                'success' => true,
                'message' => 'About page statistics updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update about page statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update about page CTA section
     */
    public function updateAboutCTA(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cta_title' => 'required|string|max:255',
            'cta_subtitle' => 'required|string|max:500',
            'cta_primary_button_text' => 'required|string|max:100',
            'cta_primary_button_link' => 'required|string|max:255',
            'cta_secondary_button_text' => 'required|string|max:100',
            'cta_secondary_button_link' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $cta = HomePageContent::firstOrCreate(['section' => 'about_cta']);
            
            $cta->title = $request->cta_title;
            $cta->subtitle = $request->cta_subtitle;
            $cta->button_text = $request->cta_primary_button_text;
            $cta->button_link = $request->cta_primary_button_link;
            $cta->service_cards = [
                'secondary_button_text' => $request->cta_secondary_button_text,
                'secondary_button_link' => $request->cta_secondary_button_link
            ];
            $cta->is_active = true;
            $cta->save();

            return response()->json([
                'success' => true,
                'message' => 'About page CTA section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update about page CTA section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Manage contact page content
     */
    public function manageContactPage()
    {
        $content = [
            'contact_hero' => HomePageContent::where('section', 'contact_hero')->first(),
            'contact_info' => HomePageContent::where('section', 'contact_info')->first(),
            'contact_faq' => HomePageContent::where('section', 'contact_faq')->first(),
            'contact_cta' => HomePageContent::where('section', 'contact_cta')->first(),
        ];
        
        return view('admin.cms.contact-page', compact('content'))->with('activePage', 'contact-cms');
    }

    /**
     * Update contact page hero section
     */
    public function updateContactHero(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $hero = HomePageContent::firstOrCreate(['section' => 'contact_hero']);
            
            $hero->title = $request->hero_title;
            $hero->subtitle = $request->hero_subtitle;
            $hero->is_active = true;
            $hero->save();

            return response()->json([
                'success' => true,
                'message' => 'Contact page hero section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update contact page hero section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update contact information section
     */
    public function updateContactInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'info_title' => 'required|string|max:255',
            'info_description' => 'required|string|max:1000',
            'contact_phone' => 'required|string|max:50',
            'contact_email' => 'required|email|max:255',
            'contact_address' => 'required|string|max:255',
            'business_hours' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $info = HomePageContent::firstOrCreate(['section' => 'contact_info']);
            
            $info->title = $request->info_title;
            $info->description = $request->info_description;
            $info->contact_phone = $request->contact_phone;
            $info->contact_email = $request->contact_email;
            $info->contact_address = $request->contact_address;
            $info->service_cards = [
                'business_hours' => $request->business_hours
            ];
            $info->is_active = true;
            $info->save();

            return response()->json([
                'success' => true,
                'message' => 'Contact information updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update contact information: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update contact FAQ section
     */
    public function updateContactFAQ(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'faq_title' => 'required|string|max:255',
            'faqs' => 'required|array|min:1',
            'faqs.*.question' => 'required|string|max:255',
            'faqs.*.answer' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $faq = HomePageContent::firstOrCreate(['section' => 'contact_faq']);
            
            $faq->title = $request->faq_title;
            $faq->service_cards = $request->faqs;
            $faq->is_active = true;
            $faq->save();

            return response()->json([
                'success' => true,
                'message' => 'FAQ section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update FAQ section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update contact page CTA section
     */
    public function updateContactCTA(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cta_title' => 'required|string|max:255',
            'cta_subtitle' => 'required|string|max:500',
            'cta_button_text' => 'required|string|max:100',
            'cta_button_link' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $cta = HomePageContent::firstOrCreate(['section' => 'contact_cta']);
            
            $cta->title = $request->cta_title;
            $cta->subtitle = $request->cta_subtitle;
            $cta->button_text = $request->cta_button_text;
            $cta->button_link = $request->cta_button_link;
            $cta->is_active = true;
            $cta->save();

            return response()->json([
                'success' => true,
                'message' => 'Contact page CTA section updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update contact page CTA section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display about page with dynamic content
     */
    public function about()
    {
        // Get CMS data for about page
        $aboutHero = HomePageContent::where('section', 'about_hero')->first();
        $aboutStory = HomePageContent::where('section', 'about_story')->first();
        $aboutMissionVision = HomePageContent::where('section', 'about_mission_vision')->first();
        $aboutValues = HomePageContent::where('section', 'about_values')->first();
        $aboutStats = HomePageContent::where('section', 'about_stats')->first();
        $aboutCTA = HomePageContent::where('section', 'about_cta')->first();
        
        // Default content if CMS data doesn't exist
        $aboutData = [
            'hero' => [
                'title' => $aboutHero && $aboutHero->is_active ? $aboutHero->title : 'About CrwdCtrl',
                'subtitle' => $aboutHero && $aboutHero->is_active ? $aboutHero->subtitle : 'Creating unforgettable moments, one event at a time'
            ],
            'story' => [
                'title' => $aboutStory && $aboutStory->is_active ? $aboutStory->title : 'Our Story',
                'content' => $aboutStory && $aboutStory->is_active ? $aboutStory->description : 'Founded with a passion for creating extraordinary experiences, CrwdCtrl began as a small team of event enthusiasts who believed that every celebration deserves to be perfect. What started as a dream to make events more memorable has grown into a trusted name in event management across Bataan and beyond.',
                'image_path' => $aboutStory && $aboutStory->is_active && $aboutStory->image_path ? $aboutStory->image_path : '/public/img/about-story.jpg'
            ],
            'mission_vision' => [
                'mission_title' => $aboutMissionVision && $aboutMissionVision->is_active && $aboutMissionVision->service_cards && isset($aboutMissionVision->service_cards['mission_title']) ? $aboutMissionVision->service_cards['mission_title'] : 'Our Mission',
                'mission_content' => $aboutMissionVision && $aboutMissionVision->is_active && $aboutMissionVision->service_cards && isset($aboutMissionVision->service_cards['mission_content']) ? $aboutMissionVision->service_cards['mission_content'] : 'To transform ordinary moments into extraordinary memories by providing innovative, personalized, and seamless event planning services that exceed expectations and create lasting impressions for our clients and their guests.',
                'vision_title' => $aboutMissionVision && $aboutMissionVision->is_active && $aboutMissionVision->service_cards && isset($aboutMissionVision->service_cards['vision_title']) ? $aboutMissionVision->service_cards['vision_title'] : 'Our Vision',
                'vision_content' => $aboutMissionVision && $aboutMissionVision->is_active && $aboutMissionVision->service_cards && isset($aboutMissionVision->service_cards['vision_content']) ? $aboutMissionVision->service_cards['vision_content'] : 'To be the leading event management company in the region, known for our creativity, reliability, and commitment to excellence. We aspire to set new standards in the industry while building lasting relationships with our clients and partners.'
            ],
            'values' => [
                'title' => $aboutValues && $aboutValues->is_active ? $aboutValues->title : 'Our Core Values',
                'values' => $aboutValues && $aboutValues->is_active && $aboutValues->service_cards ? $aboutValues->service_cards : [
                    ['title' => 'Passion', 'description' => 'We pour our hearts into every event, treating each celebration as if it were our own.'],
                    ['title' => 'Excellence', 'description' => 'We strive for perfection in every detail, ensuring flawless execution of your vision.'],
                    ['title' => 'Trust', 'description' => 'We build lasting relationships based on transparency, honesty, and mutual respect.'],
                    ['title' => 'Innovation', 'description' => 'We embrace new ideas and technologies to create unique and memorable experiences.']
                ]
            ],
            'stats' => [
                'stats' => $aboutStats && $aboutStats->is_active && $aboutStats->service_cards ? $aboutStats->service_cards : [
                    ['number' => '500+', 'label' => 'Events Successfully Planned'],
                    ['number' => '5+', 'label' => 'Years of Experience'],
                    ['number' => '98%', 'label' => 'Client Satisfaction Rate'],
                    ['number' => '50+', 'label' => 'Venue Partnerships']
                ]
            ],
            'cta' => [
                'title' => $aboutCTA && $aboutCTA->is_active ? $aboutCTA->title : 'Ready to Create Something Amazing?',
                'subtitle' => $aboutCTA && $aboutCTA->is_active ? $aboutCTA->subtitle : 'Let\'s work together to make your next event unforgettable',
                'primary_button_text' => $aboutCTA && $aboutCTA->is_active ? $aboutCTA->button_text : 'Start Planning',
                'primary_button_link' => $aboutCTA && $aboutCTA->is_active ? $aboutCTA->button_link : route('book-now'),
                'secondary_button_text' => $aboutCTA && $aboutCTA->is_active && $aboutCTA->service_cards && isset($aboutCTA->service_cards['secondary_button_text']) ? $aboutCTA->service_cards['secondary_button_text'] : 'Get in Touch',
                'secondary_button_link' => $aboutCTA && $aboutCTA->is_active && $aboutCTA->service_cards && isset($aboutCTA->service_cards['secondary_button_link']) ? $aboutCTA->service_cards['secondary_button_link'] : route('home') . '#contact'
            ]
        ];
        
        return view('about', compact('aboutData'));
    }

    /**
     * Display contact page with dynamic content
     */
    public function contact()
    {
        // Get CMS data for contact page
        $contactHero = HomePageContent::where('section', 'contact_hero')->first();
        $contactInfo = HomePageContent::where('section', 'contact_info')->first();
        $contactFAQ = HomePageContent::where('section', 'contact_faq')->first();
        $contactCTA = HomePageContent::where('section', 'contact_cta')->first();
        
        // Default content if CMS data doesn't exist
        $contactData = [
            'hero' => [
                'title' => $contactHero && $contactHero->is_active ? $contactHero->title : 'Get in Touch',
                'subtitle' => $contactHero && $contactHero->is_active ? $contactHero->subtitle : 'Ready to start planning your perfect event? We\'d love to hear from you!'
            ],
            'info' => [
                'title' => $contactInfo && $contactInfo->is_active ? $contactInfo->title : 'Let\'s Start Planning Together',
                'description' => $contactInfo && $contactInfo->is_active ? $contactInfo->description : 'Whether you\'re planning a wedding, birthday celebration, or any special event, our team is here to help bring your vision to life. Reach out to us and let\'s create something extraordinary together.',
                'phone' => $contactInfo && $contactInfo->is_active ? $contactInfo->contact_phone : '+63 912 345 6789',
                'email' => $contactInfo && $contactInfo->is_active ? $contactInfo->contact_email : 'hello@crwdctrl.ph',
                'address' => $contactInfo && $contactInfo->is_active ? $contactInfo->contact_address : 'Bataan, Philippines',
                'business_hours' => $contactInfo && $contactInfo->is_active && $contactInfo->service_cards && isset($contactInfo->service_cards['business_hours']) ? $contactInfo->service_cards['business_hours'] : 'Monday - Friday: 9:00 AM - 6:00 PM\nSaturday: 9:00 AM - 4:00 PM'
            ],
            'faq' => [
                'title' => $contactFAQ && $contactFAQ->is_active ? $contactFAQ->title : 'Frequently Asked Questions',
                'faqs' => $contactFAQ && $contactFAQ->is_active && $contactFAQ->service_cards ? $contactFAQ->service_cards : [
                    [
                        'question' => 'How far in advance should I book my event?',
                        'answer' => 'We recommend booking at least 3-6 months in advance for weddings and large events, and 1-2 months for smaller celebrations. However, we can accommodate last-minute requests depending on availability.'
                    ],
                    [
                        'question' => 'What\'s included in your event planning packages?',
                        'answer' => 'Our packages include venue coordination, vendor management, timeline planning, day-of coordination, and ongoing support throughout the planning process. Specific inclusions vary by package - contact us for details!'
                    ],
                    [
                        'question' => 'Can I customize a package to fit my specific needs?',
                        'answer' => 'Absolutely! We believe every event is unique. We offer customizable packages and can work with you to create a plan that perfectly fits your vision and budget.'
                    ]
                ]
            ],
            'cta' => [
                'title' => $contactCTA && $contactCTA->is_active ? $contactCTA->title : 'Ready to Start Planning?',
                'subtitle' => $contactCTA && $contactCTA->is_active ? $contactCTA->subtitle : 'Let\'s turn your dream event into reality',
                'button_text' => $contactCTA && $contactCTA->is_active ? $contactCTA->button_text : 'Book Your Event Now',
                'button_link' => $contactCTA && $contactCTA->is_active ? $contactCTA->button_link : route('book-now')
            ]
        ];
        
        return view('contact', compact('contactData'));
    }
} 