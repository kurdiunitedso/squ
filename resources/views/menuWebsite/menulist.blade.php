<ul id="menu-list" class="list-group">
    @foreach ($menus as $menu)
        @include('menuWebsite.menu', ['menu' => $menu, 'depth' => 0])
    @endforeach
</ul>
