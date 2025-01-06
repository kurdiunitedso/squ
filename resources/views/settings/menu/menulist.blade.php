<ul id="menu-list" class="list-group">
    @foreach ($menus as $menu)
        @include('settings.menu.menu', ['menu' => $menu, 'depth' => 0])
    @endforeach
</ul>
