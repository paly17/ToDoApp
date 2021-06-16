<?php

namespace App\Http\Controllers;

use App\Item;
use App\User;
use App\UserItem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    protected $items_per_page = 5;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        //$items = Item::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $user_items = UserItem::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $items = [];
        $items_to_display = [];
        $counter = 0;
        foreach ($user_items as $user_item){
            $counter = $counter + 1;
            $items2 = Item::where('id', $user_item->item_id)->get();
            $item = $items2->first();
            $items[] = $item;
            if($counter <= $this->items_per_page){
                $items_to_display[] = $item;
            }
        }

        $easy = true;
        $medium = true;
        $hard = true;
        $mine = true;
        $shared = true;
        $completed = true;
        $not_completed = true;

        $total_pages = ceil(count($items) / $this->items_per_page);
        if($total_pages == 0) $total_pages = 1;
        $current_page = 1;

        return view('home', compact('items', 'items_to_display', 'easy', 'medium', 'hard', 'mine', 'shared', 'completed', 'not_completed', 'current_page', 'total_pages'));
    }

    /**
     * From all items of logged user select those, which match with selected filters.
     */
    public function filterItems($easy, $medium, $hard, $mine, $shared, $completed, $not_completed){
        $user_items = UserItem::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $items = [];

        foreach ($user_items as $user_item){
            $items2 = Item::where('id', $user_item->item_id)->get();
            $item = $items2->first();
            $putItem = true;

            if((!$easy && $item->category == 'Easy') ||
                (!$medium && $item->category == 'Medium') ||
                (!$hard && $item->category == 'Hard') ||
                (!$mine && $item->shared == false) ||
                (!$shared && $item->shared == true) ||
                (!$completed && $item->completed == true) ||
                (!$not_completed && $item->completed == false)){
                $putItem = false;
            }

            if ($putItem){
                $items[] = $item;
            }
        }
        return $items;
    }

    /**
     * Filter items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function filter(Request $request){

        $easy = 0;
        $medium = 0;
        $hard = 0;
        $mine = 0;
        $shared = 0;
        $completed = 0;
        $not_completed = 0;

        if($request->has('Easy')) $easy = 1;
        if($request->has('Medium')) $medium = 1;
        if($request->has('Hard')) $hard = 1;
        if($request->has('Mine')) $mine = 1;
        if($request->has('Shared')) $shared = 1;
        if($request->has('Completed')) $completed = 1;
        if($request->has('NotCompleted')) $not_completed = 1;

        $items_to_display = [];
        $counter = 0;
        $items = $this->filterItems($easy, $medium, $hard, $mine, $shared, $completed, $not_completed);

        foreach ($items as $item){
            $counter = $counter + 1;
            if($counter <= $this->items_per_page){
                $items_to_display[] = $item;
            }
        }
        $total_pages = ceil(count($items) / $this->items_per_page);
        if($total_pages == 0)
            $total_pages = 1;
        $current_page = 1;

        return view('home', compact('items','items_to_display', 'easy', 'medium', 'hard', 'mine', 'shared', 'completed', 'not_completed', 'current_page', 'total_pages'));
    }

    /**
     * Go to previous page.
     */
    public function previousPage($easy, $medium, $hard, $mine, $shared, $completed, $not_completed, $current_page){
        if($current_page > 1)
            $current_page = $current_page - 1;

        $items = $this->filterItems($easy, $medium, $hard, $mine, $shared, $completed, $not_completed);
        $items_to_display = [];
        $counter = 0;
        foreach ($items as $item){
            $counter = $counter + 1;
            if($this->items_per_page * ($current_page - 1) + 1 <= $counter &&
            $counter <= $current_page * $this->items_per_page){
                $items_to_display[] = $item;
            }
        }
        $total_pages = ceil(count($items) / $this->items_per_page);
        if($total_pages == 0) $total_pages = 1;
        return view('home', compact('items','items_to_display', 'easy', 'medium', 'hard', 'mine', 'shared', 'completed', 'not_completed', 'current_page', 'total_pages'));
    }

    /**
     * Go to next page.
     */
    public function nextPage($easy, $medium, $hard, $mine, $shared, $completed, $not_completed, $current_page){
        $items = $this->filterItems($easy, $medium, $hard, $mine, $shared, $completed, $not_completed);
        $total_pages = ceil(count($items) / $this->items_per_page);
        if($total_pages == 0) $total_pages = 1;

        if($current_page < $total_pages)
            $current_page = $current_page + 1;

        $items_to_display = [];
        $counter = 0;
        foreach ($items as $item){
            $counter = $counter + 1;
            if($this->items_per_page * ($current_page - 1) + 1 <= $counter &&
                $counter <= $current_page * $this->items_per_page){
                $items_to_display[] = $item;
            }
        }
        return view('home', compact('items','items_to_display', 'easy', 'medium', 'hard', 'mine', 'shared', 'completed', 'not_completed', 'current_page', 'total_pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('add_item');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:70',
            'category' => 'required|string|max:70',
            'description' => 'nullable|string',
            'completed' => 'nullable',
        ]);

        $item = new Item;
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->category = $request->input('category');

        if($request->has('completed')){
            $item->completed = true;
        }

        //$item->user_id = Auth::user()->id;
        $item->save();

        $user_item = new UserItem;
        $user_item->user_id = Auth::user()->id;
        $user_item->item_id = $item->id;
        $user_item->save();

        return back()->with('success', 'Item created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        //$item = Item::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $user_item = UserItem::where('user_id', Auth::user()->id)->where('item_id', $id)->firstOrFail();
        $item = Item::where('id', $user_item->item_id)->firstOrFail();
        return view('edit_item', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:70',
            'category' => 'required|string|max:70',
            'description' => 'nullable|string',
            'completed' => 'nullable',
        ]);

        //$item = Item::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $user_item = UserItem::where('user_id', Auth::user()->id)->where('item_id', $id)->firstOrFail();
        $item = Item::where('id', $user_item->item_id)->firstOrFail();
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->category = $request->input('category');

        if($request->has('completed')){
            $item->completed = true;
        }
        else{
            $item->completed = false;
        }

        $item->save();

        if(!empty($request->input('new_user'))){
            $message = $this->addUserToShare($request->input('new_user'), $id);
            if($message != 'OK') {
                return back()->withErrors($message);
            }
        }

        return back()->with('success', 'Item edited successfully');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param int $id
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function delete(int $id)
    {
        //$item = Item::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $user_item = UserItem::where('user_id', Auth::user()->id)->where('item_id', $id)->firstOrFail();
        $item = Item::where('id', $user_item->item_id)->firstOrFail();
        return view('delete_item', compact('item'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //$item = Item::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $user_item = UserItem::where('user_id', Auth::user()->id)->where('item_id', $id)->firstOrFail();
        $item = Item::where('id', $user_item->item_id)->firstOrFail();
        $item->delete();
        return redirect()->route('item.index')->with('success', 'Item deleted successfully');
    }

    /**
     * Verifies, if user with name $user_name can be added to share item with id $item_id.
     *
     * @param int $item_id
     * @param string $user_name
     * @return string
     */
    public function verifyUser(string $user_name, int $item_id): string
    {
        // check if user is not currently logged
        if ($user_name == Auth::user()->name)
            return 'You can not share item with yourself.';

        // check if user exists
        $users = User::where('name', $user_name)->get();
        $user = $users->first();
        $arr = (array)$user;
        if (!$arr) {
            return 'This user does not exist.';
        }

        // check if this item is not already shared with given user
        //$item = Item::where('id', $item_id)->where('user_id', Auth::user()->id)->firstOrFail();
        $user_item = UserItem::where('user_id', Auth::user()->id)->where('item_id', $item_id)->firstOrFail();
        $item = Item::where('id', $user_item->item_id)->firstOrFail();
        $users = preg_split('/\s+/', $item->shared_with);
        foreach ($users as &$user) {
            if($user == $user_name){
                return 'You already share this item with given user.';
            }
        }

        return 'OK';
    }

    /**
     * Adds, user with name $user_name to share item with id $item_id.
     *
     * @param int $item_id
     * @param string $user_name
     * @return string
     */
    public function addUserToShare(string $user_name, int $item_id): string
    {
        $message = $this->verifyUser($user_name, $item_id);

        if($message == 'OK'){
            $users = User::where('name', $user_name)->get();
            $user = $users->first();
            //$item = Item::where('id', $item_id)->where('user_id', Auth::user()->id)->firstOrFail();
            $user_item = UserItem::where('user_id', Auth::user()->id)->where('item_id', $item_id)->firstOrFail();
            $item = Item::where('id', $user_item->item_id)->firstOrFail();
            if(!$item->shared){
                $item->shared_with = Auth::user()->name;
            }
            $item->shared_with = $item->shared_with . ' ' . $user->name;
            $item->shared = true;
            $item->save();

            $user_item = new UserItem;
            $user_item->user_id = $user->id;
            $user_item->item_id = $item->id;
            $user_item->save();
        }

        //return back()->with('success', 'Item edited successfully');
        return $message;
    }
}
