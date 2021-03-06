<?php namespace jorenvanhocht\Blogify\Middleware;

use App\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Request;
use jorenvanhocht\Blogify\Models\Post;

class DenyIfBeingEdited {

    /**
     * Holds the Guard Contract
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Holds an instance of the Post model
     *
     * @var Post
     */
    protected $post;

    /**
     * Holds an instance of the User model
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     * @param Post $post
     */
    public function __construct(Guard $auth, Post $post, User $user)
    {
        $this->auth = $auth;
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $hash = Request::segment(3);
        $post = $this->post->byHash ( $hash );

        if ( $post->being_edited_by != null && $post->being_edited_by != $this->auth->user()->id )
        {
            $user = $this->user->find($post->being_edited_by)->fullName;

            session()->flash('notify', [ 'danger', trans('blogify::posts.notify.being_edited', ['name' => $user]) ] );
            return redirect()->route('admin.posts.index');
        }

        return $next($request);
    }

}
