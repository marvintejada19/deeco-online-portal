<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Subject;

class SubjectsController extends Controller
{
    public function show(Subject $subject){
    	$articles = $this->sort($subject->subjectPosts, $subject->subjectRequirements);
    	$types = session()->pull('types');
    	return view('subjects.content.show', compact('subject', 'articles', 'types'));
    }

    public function showDetails(Subject $subject){
    	$students = $subject->students();
    	return view('subjects.content.details', compact('subject', 'students'));
    }

    private function sort($posts, $requirements){
    	$articles = [];
    	$types = [];
    	$i = 0;
    	$j = 0;

    	while(true){
    		if($i == count($posts) && $j == count($requirements)){
    			break;
    		} else if($i == count($posts)){
    			$articles[] = $requirements[$j];
				$types[] = 'R';
				$j++;
			} else if($j == count($requirements)){
				$articles[] = $posts[$i];
				$types[] = 'P';
				$i++;
    		} else if($posts[$i]->published_at > $requirements[$j]->published_at){
				$articles[] = $posts[$i];
				$types[] = 'P';
				$i++;
			} else if($posts[$i]->published_at <= $requirements[$j]->published_at){
				$articles[] = $requirements[$j];
				$types[] = 'R';
				$j++;
			} else {
				break;
			}
    	}

    	session()->put('types', $types);
    	return $articles;
    }
}
