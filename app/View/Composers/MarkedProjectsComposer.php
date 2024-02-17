<?php

namespace App\View\Composers;

use App\Http\Controllers\ProjectController;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class MarkedProjectsComposer
{
  /**
   * Bind data to the view.
   */
  public function compose(View $view): void
  {

    if (Auth::user()) {
      $projectController = new ProjectController();
      $markedProjects = $projectController->markedProjects(Auth::id());
      $view->with('markedProjects', $markedProjects);
    }
  }
}