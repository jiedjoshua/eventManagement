<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Create Event</title>
  <style>
    @keyframes pulse {
      0%, 100% {
        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
      }
      50% {
        box-shadow: 0 0 8px 6px rgba(59, 130, 246, 0.4);
      }
    }

    .pulse {
      animation: pulse 2s infinite;
      
    }
  </style>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gradient-to-br from-sky-100 via-white to-indigo-200 min-h-screen flex items-center justify-center p-6">

  <div class="w-full max-w-3xl bg-white/70 backdrop-blur-md rounded-2xl shadow-2xl p-8">


    
    <!-- Header -->
    <div class="mb-8 text-center">
      <h1 class="text-3xl font-bold text-gray-800">Create New Event</h1>
      <p class="text-gray-500">Step-by-step guided form</p>
    </div>

    <template id="steps-template">
      <div class="flex flex-col items-center cursor-pointer">
        <div class="w-8 h-8 rounded-full border flex items-center justify-center text-gray-500 bg-white border-gray-300 transition-colors duration-300">
          <i data-lucide="info" class="w-5 h-5"></i>
        </div>
        <span class="mt-2 text-gray-500 text-sm">Step</span>
      </div>
    </template>

    <!-- Progress Bar -->
    <div class="relative px-2 mb-6 h-14 flex items-center">
     <!-- Background line -->
<div class="absolute top-7 left-5 right-5 h-1 bg-gray-200 rounded-full"></div>
<!-- Progress line -->
<div id="progress-bar" class="absolute top-7 left-5 right-5 h-1 bg-blue-600 rounded-full transition-all duration-500" style="width: 0%"></div>

      <!-- Steps container -->
      <div id="progress-steps" class="flex justify-between w-full relative z-10 px-0 gap-x-4"></div>
    </div>

    <!-- Form -->
    <form id="eventForm" class="space-y-6">

      <!-- Step 1: Basic Info -->
      <div class="step space-y-4">
        <h2 class="text-xl font-semibold text-gray-800">1. Basic Information</h2>
        <div>
          <label class="block mb-1 font-medium text-gray-700">Event Name <span class="text-red-500">*</span></label>
          <input type="text" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div>
          <label class="block mb-1 font-medium text-gray-700">Event Type</label>
          <select class="w-full p-3 border border-gray-300 rounded-lg">
            <option>Wedding</option>
            <option>Birthday</option>
            <option>Corporate</option>
          </select>
        </div>
        <div>
          <label class="block mb-1 font-medium text-gray-700">Event Package Type</label>
          <input type="text" class="w-full p-3 border border-gray-300 rounded-lg">
        </div>
      </div>

      <!-- Step 2: Schedule & Location -->
      <div class="step hidden space-y-4">
        <h2 class="text-xl font-semibold text-gray-800">2. Schedule & Location</h2>
        <div>
          <label class="block mb-1 font-medium text-gray-700">Event Date</label>
          <input type="date" class="w-full p-3 border border-gray-300 rounded-lg">
        </div>
        <div>
          <label class="block mb-1 font-medium text-gray-700">Event Time</label>
          <div class="flex gap-4">
            <input type="time" class="w-full p-3 border border-gray-300 rounded-lg">
            <input type="time" class="w-full p-3 border border-gray-300 rounded-lg">
          </div>
        </div>
        <div>
          <label class="block mb-1 font-medium text-gray-700">Venue Name</label>
          <input type="text" class="w-full p-3 border border-gray-300 rounded-lg">
        </div>
        <div>
          <label class="block mb-1 font-medium text-gray-700">Event Duration</label>
          <input type="text" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg" readonly value="Auto-calculated">
        </div>
      </div>

      <!-- Step 4: Guest Management -->
      <div class="step hidden space-y-4">
        <h2 class="text-xl font-semibold text-gray-800">3. Guest Management</h2>
        <label class="block mb-1 font-medium text-gray-700">Estimated Guest Count</label>
        <input type="number" class="w-full p-3 border border-gray-300 rounded-lg">

        <label class="block mb-1 font-medium text-gray-700">Upload Guest List</label>
        <input type="file" accept=".csv" class="w-full p-3 border border-gray-300 rounded-lg">

        <label class="flex items-center gap-2 mt-2">
          <input type="checkbox" class="accent-blue-600"> Enable RSVP Form?
        </label>

        <label class="block mt-4 mb-1 font-medium text-gray-700">RSVP Deadline</label>
        <input type="date" class="w-full p-3 border border-gray-300 rounded-lg">
      </div>

      <!-- Step 5: Additional Settings -->
      <div class="step hidden space-y-4">
        <h2 class="text-xl font-semibold text-gray-800">5. Additional Settings</h2>
        <label class="flex items-center gap-2">
          <input type="checkbox" class="accent-blue-600"> Allow Guests to Bring +1?
        </label>

        <label class="block mt-4 mb-1 font-medium text-gray-700">Send Reminders Before Event?</label>
        <select class="w-full p-3 border border-gray-300 rounded-lg">
          <option value="">None</option>
          <option>1 day</option>
          <option>3 days</option>
          <option>1 week</option>
        </select>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex justify-between items-center pt-6 border-t">
        <button type="button" id="prevBtn" class="px-4 py-2 rounded-lg bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition" disabled>Previous</button>
        <div class="space-x-2">
          <button type="button" id="nextBtn" class="px-6 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">Next</button>
          <button type="submit" class="px-6 py-2 rounded-lg bg-green-600 text-white font-semibold hidden" id="submitBtn">Save</button>
          <button type="reset" class="px-6 py-2 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600">Cancel</button>
        </div>
      </div>
    </form>
  </div>

  <script>
    const stepTitles = [
      { name: "Basic", icon: "info" },
      { name: "Schedule", icon: "calendar" },
      { name: "Guests", icon: "users" },
      { name: "Settings", icon: "settings" },
    ];

    const stepsContainer = document.getElementById("progress-steps");
    const progressBar = document.getElementById("progress-bar");
    const stepTemplate = document.getElementById("steps-template").content;

    stepTitles.forEach((step, index) => {
      const stepEl = stepTemplate.cloneNode(true);
      const iconEl = stepEl.querySelector("i");
      iconEl.setAttribute("data-lucide", step.icon);
      stepEl.querySelector("span").textContent = step.name;
      stepEl.querySelector("div").classList.add("border-gray-300", "bg-white", "text-gray-500");
      stepsContainer.appendChild(stepEl);
    });
    lucide.createIcons();

    const steps = document.querySelectorAll("#progress-steps > div");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const submitBtn = document.getElementById("submitBtn");
    let currentStep = 0;

    function updateProgressBar(n) {
      const totalSteps = steps.length;
      const progressPercent = (n) / (totalSteps - 1) * 100;
      progressBar.style.width = `${progressPercent}%`;

      // Update each step style
      steps.forEach((step, index) => {
        const circle = step.querySelector("div"); // the circle div inside each step
        const label = step.querySelector("span");

        if (index < n) {
          // Completed step
          circle.classList.remove("border-gray-300", "bg-white", "text-gray-500", "pulse");
          circle.classList.add("border-blue-600", "bg-blue-600", "text-white");
          label.classList.remove("text-gray-500");
          label.classList.add("text-blue-600", "font-semibold");
        } else if (index === n) {
          // Active step
          circle.classList.remove("border-gray-300", "bg-white", "text-gray-500");
          circle.classList.add("border-blue-600", "bg-white", "text-blue-600", "pulse");
          label.classList.remove("text-gray-500");
          label.classList.add("text-blue-600", "font-semibold");
        } else {
          // Pending steps
          circle.classList.remove("border-blue-600", "bg-blue-600", "text-white", "text-blue-600", "pulse");
          circle.classList.add("border-gray-300", "bg-white", "text-gray-500");
          label.classList.remove("text-blue-600", "font-semibold");
          label.classList.add("text-gray-500");
        }
      });
    }

    function showStep(n) {
      const allSteps = document.querySelectorAll(".step");
      allSteps.forEach((step, i) => {
        step.classList.toggle("hidden", i !== n);
      });

      updateProgressBar(n);

      prevBtn.disabled = n === 0;
      nextBtn.classList.toggle("hidden", n === steps.length - 1);
      submitBtn.classList.toggle("hidden", n !== steps.length - 1);
    }

    prevBtn.addEventListener("click", () => {
      if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
      }
    });

    nextBtn.addEventListener("click", () => {
      const form = document.getElementById("eventForm");
      // You can add validation here for current step before moving on
      if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
      }
    });

    document.getElementById("eventForm").addEventListener("submit", e => {
      e.preventDefault();
      alert("Event saved!");
      // Submit logic here
    });

    showStep(currentStep);
  </script>
</body>
</html>
