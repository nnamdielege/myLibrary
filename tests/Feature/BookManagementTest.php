<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {

        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Nnamdi',
        ]);

        $book = Book::first();

        // $response->assertOk();
        // $response->assertSuccessful();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
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

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author' => 'Nnamdi Elege',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('Nnamdi Elege', Book::first()->author);

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Second Title',
            'author' => 'Nnamdi',
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
