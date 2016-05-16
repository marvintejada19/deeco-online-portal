<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\File;
use App\Models\Subjects\Subject;
use Auth;

class SubjectArticlesService
{
    /**
     * Sort all articles (which consists of subject posts, requirements, and examinations)
     * according to their 'published_at' attribute
     *
     * @param Subject $subject
     * @return array $articles
     */
    public function sortArticles(Subject $subject){
        if (!strcmp(Auth::user()->getRole(), 'Faculty')){
            $posts = $subject->subjectPosts()->get();
            $requirements = $subject->subjectRequirements()->get();
            $examinations = $subject->subjectExaminations()->get();
        } else {
            $posts = $subject->subjectPosts()->published()->get();
            $requirements = $subject->subjectRequirements()->published()->get();
            $examinations = $subject->subjectExaminations()->published()->get();
        }
        $articles = [];
        $types = [];
        $i = $j = $k = 0;

        while(true){
            $nextPostDate = null;
            $nextRequirementDate = null;
            $nextExaminationDate = null;
            if($i < count($posts)){
                $nextPostDate = $posts[$i]->getUnformattedDate('published_at');
            }
            if($j < count($requirements)){
                $nextRequirementDate = $requirements[$j]->getUnformattedDate('published_at');
            }
            if($k < count($examinations)){
                $nextExaminationDate = $examinations[$k]->getUnformattedDate('published_at');
            }

            $nextArticleDate = max($nextPostDate, $nextRequirementDate, $nextExaminationDate);
            if ($nextArticleDate == null){
                break;
            } else if ($k < count($examinations) && $examinations[$k]->getUnformattedDate('published_at') == $nextArticleDate){
                $articles[] = $examinations[$k];
                $types[] = 'E';
                $k++;
            } else if($j < count($requirements) && $requirements[$j]->getUnformattedDate('published_at') == $nextArticleDate){
                $articles[] = $requirements[$j];
                $types[] = 'R';
                $j++;
            } else if($i < count($posts) && $posts[$i]->getUnformattedDate('published_at') == $nextArticleDate){
                $articles[] = $posts[$i];
                $types[] = 'P';
                $i++;
            } else {
                break;    
            }
        }
        session()->put('types', $types);
        return $articles;
    }
}
