<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomePageContent;

class HomePageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hero Section
        HomePageContent::updateOrCreate(
            ['section' => 'hero'],
            [
                'title' => 'Celebrate Life\'s Special Moments',
                'subtitle' => 'We make your dream events come true — weddings, birthdays, and more!',
                'button_text' => 'Book Now',
                'button_link' => '/book-now',
                'is_active' => true
            ]
        );

        // Services Section
        HomePageContent::updateOrCreate(
            ['section' => 'services'],
            [
                'title' => 'Our Event Services',
                'service_cards' => [
                    [
                        'title' => 'Weddings',
                        'description' => 'Beautiful and memorable wedding event planning tailored to your dreams.',
                        'type' => 'wedding',
                        'image' => 'wedding.webp',
                        'image_path' => '/public/img/wedding.webp',
                        'link' => '/packages?type=wedding'
                    ],
                    [
                        'title' => 'Birthdays',
                        'description' => 'Fun and exciting birthday celebrations customized for all ages.',
                        'type' => 'birthday',
                        'image' => 'birthday.jpg',
                        'image_path' => '/public/img/birthday.jpg',
                        'link' => '/packages?type=birthday'
                    ],
                    [
                        'title' => 'Debuts',
                        'description' => 'Elegant debut parties that mark this special milestone with style.',
                        'type' => 'debut',
                        'image' => 'debut.webp',
                        'image_path' => '/public/img/debut.webp',
                        'link' => '/packages?type=debut'
                    ],
                    [
                        'title' => 'Baptisms',
                        'description' => 'Graceful baptism events that celebrate faith and family.',
                        'type' => 'baptism',
                        'image' => 'baptism.jpg',
                        'image_path' => '/public/img/baptism.jpg',
                        'link' => '/packages?type=baptism'
                    ]
                ],
                'is_active' => true
            ]
        );

        // About Section
        HomePageContent::updateOrCreate(
            ['section' => 'about'],
            [
                'title' => 'About Us',
                'description' => 'We are passionate about creating unforgettable events that bring joy and lasting memories. With years of experience in event planning, we understand that every celebration is unique and deserves personalized attention.',
                'is_active' => true
            ]
        );

        // Contact Section
        HomePageContent::updateOrCreate(
            ['section' => 'contact'],
            [
                'title' => 'Get In Touch',
                'contact_phone' => '+1 (555) 123-4567',
                'contact_email' => 'info@eventmanagement.com',
                'contact_address' => '123 Event Street, Celebration City, CC 12345',
                'is_active' => true
            ]
        );
    }
} 