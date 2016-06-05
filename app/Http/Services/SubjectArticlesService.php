<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\File;
use App\Models\GradeSectionSubjects\GradeSectionSubject;
use App\Models\GradeSectionSubjects\GradeSectionSubjectPost;
use App\Models\GradeSectionSubjects\GradeSectionSubjectRequirement;
use App\Models\Examinations\Deployment;
use Auth;

class SubjectArticlesService
{
    /**
     * Sort all articles (which consists of posts, requirements, and examinations)
     * according to their 'publish_on' attribute
     *
     * @param GradeSectionSubject $gradeSectionSubject
     * @return array $articles
     */
    public function sortArticles(GradeSectionSubject $gradeSectionSubject){
        if (!strcmp(Auth::user()->getRole(), 'Faculty')){
            $posts = GradeSectionSubjectPost::where('grade_section_subject_id', $gradeSectionSubject->id)->get();
            $requirements = GradeSectionSubjectRequirement::where('grade_section_subject_id', $gradeSectionSubject->id)->get();
            $examinations = Deployment::where('grade_section_subject_id', $gradeSectionSubject->id)->get();
            //$adminArticles = $subject->articles()->published()->get();
            $adminArticles = [];
        } else {
            $posts = GradeSectionSubjectPost::where('grade_section_subject_id', $gradeSectionSubject->id)->published()->get();
            $requirements = GradeSectionSubjectRequirement::where('grade_section_subject_id', $gradeSectionSubject->id)->published()->get();
            $examinations = Deployment::where('grade_section_subject_id', $gradeSectionSubject->id)->published()->get();
            //$adminArticles = $subject->articles()->published()->get();
            $adminArticles = [];
        }
        $articles = [];
        $types = [];
        $i = $j = $k = $l = 0;

        while(true){
            $nextPostDate = null;
            $nextRequirementDate = null;
            $nextExaminationDate = null;
            $nextAdminArticleDate = null;
            if($i < count($posts)){
                $nextPostDate = $posts[$i]->getUnformattedDate('publish_on');
            }
            if($j < count($requirements)){
                $nextRequirementDate = $requirements[$j]->getUnformattedDate('publish_on');
            }
            if($k < count($examinations)){
                $nextExaminationDate = $examinations[$k]->getUnformattedDate('publish_on');
            }
            if($l < count($adminArticles)){
                $nextAdminArticleDate = $adminArticles[$l]->getUnformattedDate('publish_on');
            }

            $nextArticleDate = max($nextPostDate, $nextRequirementDate, $nextExaminationDate, $nextAdminArticleDate);
            if ($nextArticleDate == null){
                break;
            } else if ($l < count($adminArticles) && $adminArticles[$l]->getUnformattedDate('publish_on') == $nextArticleDate){
                $articles[] = $adminArticles[$l];
                $types[] = 'A';
                $l++;
            } else if ($k < count($examinations) && $examinations[$k]->getUnformattedDate('publish_on') == $nextArticleDate){
                $articles[] = $examinations[$k];
                $types[] = 'E';
                $k++;
            } else if ($j < count($requirements) && $requirements[$j]->getUnformattedDate('publish_on') == $nextArticleDate){
                $articles[] = $requirements[$j];
                $types[] = 'R';
                $j++;
            } else if ($i < count($posts) && $posts[$i]->getUnformattedDate('publish_on') == $nextArticleDate){
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
