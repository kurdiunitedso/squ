<?php

namespace App\Http\Controllers\CP\Settings;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Log;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod("GET")) {

            $menus = Menu::with('children')->whereNull('parent_id')->orderBy('order')->get();
            return view('settings.menu.index', compact('menus'));
        } else if ($request->isMethod('POST')) {
            $menus = Menu::with('children')->whereNull('parent_id')->orderBy('order')->get();
            $view = view('settings.menu.menulist', ['menus' => $menus])->render();
            return response()->json(['message' => 'Menu list updated !', 'listView' => $view]);
        }
    }

    public function edit(Request $request, Menu $menu)
    {
        $menu->load('parent');
        $menus = Menu::whereNull('parent_id')->get();
        $earnedMenu = [];
        if ($menu->parent)
            $earnedMenu = [$menu->parent->id];
        $createView = view('settings.menu.addedit_modal', [
            'menu' => $menu,
            'menus' => $menus,
            'earnedMenu' => $earnedMenu
        ])->render();

        return response()->json(['createView' => $createView]);
    }

    public function update(Request $request, Menu $menu)
    {
        $menu->name = $request->name;
        $menu->name_en = $request->name_en;
        $menu->name_he = $request->name_he;
        $menu->parent_id = $request->parent_id;
        $menu->icon_svg = $request->icon_svg;
        $menu->order = $request->order;
        $menu->save();

        return response()->json(['status' => true, 'message' => 'Menu Updated']);
    }
}
