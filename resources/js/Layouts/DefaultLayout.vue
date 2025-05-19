<template>
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="font-bold text-xl text-teal-600">League Simulator</div>
                <nav>
                    <a href="/" class="mx-2 text-gray-700 hover:text-teal-700 font-medium">Teams</a>
                    <a href="/fixtures" class="mx-2 text-gray-700 hover:text-teal-700 font-medium">Fixtures</a>
                    <a href="/simulation" class="mx-2 text-gray-700 hover:text-teal-700 font-medium">Simulation</a>
                </nav>
            </div>
        </header>
        <main class="max-w-7xl mx-auto py-8 px-4">
            <slot />
        </main>
        <footer class="text-center text-sm text-gray-500 py-4">© {{ new Date().getFullYear() }} League Simulator</footer>
    </div>
</template>
