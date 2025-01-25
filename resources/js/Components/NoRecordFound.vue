<template>
    <div
        class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 flex items-center justify-center p-4"
    >
        <div class="text-center">
            <!-- Animated illustration -->
            <div class="mb-8 relative">
                <div class="animate-float">
                    <svg
                        class="mx-auto w-48 h-48 text-gray-400"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                        />
                    </svg>
                </div>
                <!-- Decorative elements -->
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full"
                >
                    <div class="flex justify-center space-x-2">
                        <div
                            class="w-2 h-2 bg-blue-500 rounded-full animate-bounce delay-100"
                        ></div>
                        <div
                            class="w-2 h-2 bg-blue-500 rounded-full animate-bounce delay-200"
                        ></div>
                        <div
                            class="w-2 h-2 bg-blue-500 rounded-full animate-bounce delay-300"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Text content -->
            <h2 class="text-3xl font-bold text-gray-800 mb-4">
                ރެކޯރޑެއް ނުފެނުނު
            </h2>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                މަޢާފުކުރައްވާ! ތިޔަ ހޯއްދަވާ މަޢުލޫމާތު އަޅުގަނޑުމެންގެ
                ރިކޯރޑްތަކުގައި ނެތް
            </p>
        </div>
    </div>
</template>
