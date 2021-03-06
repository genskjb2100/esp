<?php namespace ESP\Http\Middleware;


use Closure;
use Auth;

class CustomAuthentication {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		
		if (!Auth::check()) {
			return redirect('/');
		}
		return $next($request);
	}

}
