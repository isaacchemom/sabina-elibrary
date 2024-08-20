<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\items;
use App\Models\Payment;
use App\Models\categories;
use Cart;


class BookController extends Controller
{
    public function welcome()
    {
        //$books = Book::latest()->get();

       // return view('welcome', compact('books'));
       //$books=items::with('categories')->get();
       $bookss1 = items::with('categories')->select('category_id')->distinct()->get();
       $check=3;
        $books = items::latest()->get();
        $cart = session()->get('cart', []);
      //  View::share('bookss', $bookss);
        return view('welcome', compact('books', 'check', 'bookss1','cart'));
    }




    public function transactions()
    {
        //$trans = Transaction::latest()->get();

       // return view('books.transactions', compact('trans'));
       $trans=Transaction::with('items')->latest()->get();

       return response()->json(['data'=>$trans]);





    }


    public function deleteTransaction($id)
    {
        //$trans = Transaction::latest()->get();

       // return view('books.transactions', compact('trans'));

       try {
        $trans=Transaction::find($id);
        $trans->delete();

        //to delete categories with its related items

       return response()->json(['message'=>'ITEM DELETED SUCCESSFULLY'],200);

   } catch (QueryException $e) {
       return response()->json(['error' => 'Database Error:Contact sytem admin!!'], 500);
   } catch (\Exception $e) {
       return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
   }

    }

     public function payments()
    {
       // $pays = Payment::latest()->get();
        $pays = Payment::with('transaction')->latest()->get();
        //return view('books.payments', compact('pays'));
         return response()->json(['data'=>$pays]);
    }

    public function create()
    {
        return view('books.create');
    }
    public function store(Request $request)
    {
        $request->validate([
           'title'=>'required',
           'price'=>'required',
           'desc'=>'required',
       ]);

        Book::create($request->all());
        return back();
    }
    public function book($id)
    {
        $book = Book::find($id);
        $books = Book::latest()->get();


        return view('books.book', compact('book', 'books'));
    }

    public function addToCart(Request $request, $id)
    {
        //$book = Book::find($id);
        $book = items::find($id);
        $check=2;
        $check5=5;

        $cart = session()->get('cart', []);

        $bookss = items::with('categories')->select('category_id')->distinct()->get();
        return view('books.cart', compact('book' ,'check', 'bookss','cart', 'check5'));

     /*   Cart::add(array(
        'id' => $rowId,
        'name' => $book->title,
        'price' => $book->price,
        'quantity' =>$quantity,
        'image'=>$book->image
)); */

       // $books = \Cart::getContent();
       // $subTotal = Cart::getSubTotal();
        //$cartTotalQuantity = Cart::getTotalQuantity();
        //return view('books.cart', compact('book','subTotal','cartTotalQuantity'));
        //$cartTotalQuantity = Cart::getTotalQuantity();

    }

    public function addTo(Request $request)
    {
        $book = items::find($request->id); // Use $request->id to get the book ID

        if (!$book) {
            return response()->json(['error' => 'Book not found.'], 404);
        }

        $cart = session()->get('cart', []);

      /*  if (isset($cart[$book->id])) {
            $cart[$book->id]['quantity']++;
        } else {
            $cart[$book->id] = [
                "title" => $book->title,
                "quantity" => 1,
                "price" => $book->price,
                "img_path" => $book->img_path
            ];
        }*/
        if (!isset($cart[$book->id])) {
            // Add the item to the cart if it doesn't exist
            $cart[$book->id] = [
                "title" => $book->title,
                "quantity" => 1, // Set the initial quantity to 1
                "price" => $book->price,
              //  "img_path" => $book->img_path,
                 "file_path" => $book->file_path,
                 'ms_path'=>$book ->ms_path,
            ];
        }


        session()->put('cart', $cart);

        $totalItems = array_sum(array_column($cart, 'quantity'));

        return response()->json(['success' => 'Item added to cart successfully!',

        'totalItems' => $totalItems
        ]);
    }


    public function showCart()
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);

          // Get all item IDs from the cart
        $itemIds = array_keys($cart);

         // Store the phone number in the session
//session(['phoneNumber' => $phone]);
  $phone = session('phoneNumber', null);

// Correct the query with multiple where conditions
$transactionStatuses = Transaction::whereIn('item_id', $itemIds)
    ->where('phone', $phone)
    ->pluck('status', 'item_id');

        // Return the view with cart items
        return view('layouts.store', compact('cart','transactionStatuses'));
    }

    // CartController.php
public function removeCartItem(Request $request)
{
    $cart = session()->get('cart', []);
    $itemId = $request->input('id');

    if (isset($cart[$itemId])) {
        unset($cart[$itemId]); // Remove the item from the cart
        session()->put('cart', $cart); // Update the session
        return response()->json(['success' => 'Item removed from cart.']);
    }

    return response()->json(['error' => 'Item not found in cart.'], 404);
}


    public function cart()
    {   $books = \Cart::getContent();
        $subTotal = Cart::getSubTotal();
        $cartTotalQuantity = Cart::getTotalQuantity();
        return view('books.cart', compact('books','subTotal','cartTotalQuantity'));
    }

     public function download()
        {   $books = \Cart::getContent();

            return view('books.download');
        }
}
