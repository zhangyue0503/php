<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/10
 * Time: 下午12:18
 */

$xml = simplexml_load_file('books4.xml');

foreach($xml->book as $book){
    echo "<div><h2>$book->title";

    if(isset($book->title['edition'])){
        echo " (Edition {$book->title['edition']})";
    }

    echo "</h2>";

    foreach($book->author as $author){
        echo "<span class=\"label\">Author</span>:$author<br/>";
    }
    echo "<span class=\"label\">Published:</span> $book->year<br/>";

    if(isset($book->pages)){
        echo "<span class=\"label\">Pages:</span> $book->pages<br/>";
    }

    if(isset($book->chapter)){
        echo 'Table of Contents<ul>';
        foreach($book->chapter as $chapter){
            echo '<li>';
            if(isset($chapter['number'])){
                echo "Chapter {$chapter['number']}:";
            }
            echo $chapter;
            if(isset($chapter['pages'])){
                echo " {$chapter['pages']} Pages";
            }
            echo '</li>';
        }
    }
    if(isset($book->cover)){
        $img = @getimagesize($book->cover['filename']);
        echo "<img src=\"{$book->cover['filename']}\" $image[3] border='0'><br>";
    }
    echo '</div>';
}