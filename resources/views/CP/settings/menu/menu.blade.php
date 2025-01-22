<li class="list-group-item" data-id="{{ $menu->id }}" class="draggable" data-parent="{{ $menu->parent_id }}"
    data-depth="{{ $depth }}">
    <div class="d-flex align-items-center justify-content-between">
        <div class="text-primary fw-bold">
            @if (count($menu->children))
                <span class="tree-handle ">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif
            @if ($menu->icon_svg)
                <span class="svg-icon svg-icon-2">
                    {!! $menu->icon_svg !!}
                </span>
            @endif
            {{ $menu->name_en }}
        </div>
        <div class="btn-group btn-group-sm ms-4" role="group" aria-label="Basic example">
            <button type="button" data-edit-url="{{ route('settings.menus.edit', ['menu' => $menu->id]) }}"
                class="btn btn-outline btn-outline-dashed btn-outline-dark btn-active-light-dark btnEditMenuItem">
                <span class="indicator-label">Edit</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </div>
    @if (count($menu->children))
        <ul class="list-group mt-2 ps-12 pe-6">
            @foreach ($menu->children as $child)
                @include('CP.settings.menu.menu', ['menu' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @endif
</li>
