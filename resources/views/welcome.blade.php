<x-app-layout>
    <div class="dark flex justify-center items-center min-h-screen">
        <div class="transition duration-1000 w-3/4 max-w-lg p-8 border-4 rounded-lg border-[color:var(--border)] text-[color:var(--text)]">
            <h1 class="text-center text-3xl font-bold">Welcome to my page</h1>
            <p class="text-center mb-4">About the Page!</p>
            <p class="text-center mb-2">Something you need to know before using this page:</p>

            <ol class="list-decimal">
                <li>This page is meant for searching foods, products and ingredients,</li>
                <li>This page uses an API database that's free for all users worldwide, so the foods, products and ingredients may vary,</li>
                <li>This page may have some issues that haven't been discovered yet,</li>
                <li>It may also be a bit slow or sometimes crash soo be patient!</li>
            </ol>

            <a href="{{ route('dashboard') }}"
                class="block w-full px-6 py-2 mt-4 text-center transition ease-in-out duration-300 active:scale-95 rounded-md 
                       bg-[var(--bg)] text-[var(--text)] border border-[var(--border)]
                       hover:bg-[var(--text)] hover:text-[var(--bg)]
                       dark:bg-[var(--bg)] dark:text-[var(--text)] dark:border-[var(--border)] dark:hover:bg-[var(--text)] dark:hover:text-[var(--bg)]"
                onclick="setActiveDashboard()">
                Let's get started
            </a>

        </div>
    </div>

    <script>
        // Active link color
        function setActiveDashboard() {
            sessionStorage.setItem('activeLink', 'dashboard');
            document.querySelectorAll('nav a').forEach(link => {
                const linkType = link.getAttribute('data-link');
                if (linkType === 'dashboard') {
                    link.classList.add('text-green-500', 'shadow-green-500');
                }
            });
        }
        window.addEventListener('DOMContentLoaded', () => {
            const activeLink = sessionStorage.getItem('activeLink');
            if (activeLink === 'dashboard') {
                document.querySelectorAll('nav a').forEach(link => {
                    const linkType = link.getAttribute('data-link');
                    if (linkType === 'dashboard') {
                        link.classList.add('text-green-500', 'shadow-green-500');
                    }
                });
            }
        });
    </script>
</x-app-layout>
