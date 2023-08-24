<aside id="default-sidebar" class="z-40 w-64 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="px-3 py-4 overflow-y-auto border bg-gray-50 bg-white sm:rounded-lg">
        <ul class="space-y-2 font-medium">
            <x-navbar-item route="dashboard" icon="home">Home</x-navbar-item>
            <x-navbar-item route="profile.show" icon="user">Profile</x-navbar-item>
            <x-navbar-item route="users" icon="users">Users</x-navbar-item>
            <x-navbar-item icon="document">Files</x-navbar-item>
            <x-navbar-item icon="academic-cap">Courses</x-navbar-item>
            <x-navbar-item route="roles" icon="identification">Roles</x-navbar-item>
            <x-navbar-item icon="lock-closed">Permissions</x-navbar-item>
            <x-navbar-item route="logout" icon="logout">Logout</x-navbar-item>
        </ul>
    </div>
</aside>
