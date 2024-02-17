<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WorkspaceController;

class MarkedWorkspacesComposer
{
  /**
   * Bind data to the view.
   */
  public function compose(View $view): void
  {

    if (Auth::user()) {
      $workspaceController = new WorkspaceController();
      $markedSpaces = $workspaceController->markedWorkspaces(Auth::id());
      $view->with('markedWorkspaces', $markedSpaces);
    }
  }
}