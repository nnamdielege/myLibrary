<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {

        //$this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Nnamdi',
        ]);

        //$response->assertOk();
        $response->assertSuccessful();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Nnamdi',
        ]);

        $response->assertSessionHasErrors('title');
        // $response->assertSuccessful();
    }

    /** @test */
    public function a_author_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Second Title',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');

        // $response->assertSessionHasErrors('author');
        // $response->assertSuccessful();
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Second Title',
            'author' => 'Nnamdi',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'Nnamdi Elege',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('Nnamdi Elege', Book::first()->author);
    }
}
