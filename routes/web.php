<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TikectController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TeamCreateCntroller;
use App\Http\Controllers\Team_leaderController;
use App\Http\Controllers\agentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChattestController;
use App\Http\Controllers\messageController;



/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::middleware(['role:Super Admin'])->group(function () {
   /*
|--------------------------------------------------------------------------
| Permissions
|--------------------------------------------------------------------------
*/
Route::get('/permission', [PermissionController::class, 'showPermission'])->name('permission.show');
Route::post('/permission', [PermissionController::class, 'store'])->name('permission.add');

Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index');
Route::get('/permission/fetch', [PermissionController::class, 'fetch'])->name('permission.fetch');

Route::get('/permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
Route::post('/permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
Route::post('/permission/delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');

/*
|--------------------------------------------------------------------------
| Roles
|--------------------------------------------------------------------------
*/
Route::get('/role/create', [RoleController::class, 'showRole'])->name('role.show');
Route::post('/role/create', [RoleController::class, 'store'])->name('role.create');

Route::get('/role', [RoleController::class, 'index'])->name('role.index');
Route::get('/role/fetch', [RoleController::class, 'fetch'])->name('role.fetch');

Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
Route::get('/role/create', [RoleController::class, 'showrole'])->name('role.show');
Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');

Route::post('/role/delete/{id}', [RoleController::class, 'destory'])->name('role.destroy');

Route::get('/user', [RoleController::class, 'User_data'])->name('role.data');

Route::post('/role/user/{id}', [RoleController::class, 'role_assign'])->name('role.user');



});//middle complete



Route::get('/ticket/assign',[Team_leaderController::class,'showform'])->name('ticket.showform');




//customer

Route::get('/customer/create',[CustomerController::class,'showTickets'])->name('customer.create');

Route::post('/customer/create',[CustomerController::class,'store'])->name('customer.store');

Route::get('/customer/showindex',[CustomerController::class,'showindex'])->name('customer.showindex');

Route::get('/customer/index',[CustomerController::class,'index'])->name('customer.fetch');
Route::get('customer/edit/{id}',[CustomerController::class,'edit'])->name('customer.edit');
Route::post('customer/update/{id}',[CustomerController::class,'update'])->name('customer.update');
Route::post('customer/delete/{id}',[CustomerController::class,'delete'])->name('customer.delete');

Route::get('/customer/alldata',[CustomerController::class,'getdata'])->name('customer.data');
Route::get('/customer/data',[CustomerController::class,'data'])->name('customer.datalist');



//admin

Route::get('/test-view', function () {
    return view('admin.team'); 
});



Route::get('/admin/team/create',[TeamCreateCntroller::class,'userget'])->name('team.create');
Route::post('/admin/team/create',[TeamCreateCntroller::class,'store'])->name('team.store');
Route::get('/admin/team/index',[TeamCreateCntroller::class,'showindex'])->name('team.showindex');
Route::get('/admin/team/data',[TeamCreateCntroller::class,'fetch'])->name('team.fetch');
Route::get('/admin/team/edit/{id}',[TeamCreateCntroller::class,'edit'])->name('team.edit');
Route::post('/admin/team/update/{id}',[TeamCreateCntroller::class,'update'])->name('team.update');
Route::post('/admin/team/delete/{id}',[TeamCreateCntroller::class,'delete'])->name('team.delete');
Route::get('/admin/team/assign',[TeamCreateCntroller::class,'showForm'])->name('team.showform');
Route::post('/admin/team/assign',[TeamCreateCntroller::class,'assign'])->name('team.assign');

Route::get('/admin/index',[TeamCreateCntroller::class,'index'])->name('admin.fetch');
Route::post('/admin/tickets/{id}/status', [TeamCreateCntroller::class, 'update_status'])->name('admin.status.update');

Route::get('/admin/tickets/{id}/accept', [TeamCreateCntroller::class, 'acceptTicket'])->name('admin.ticket.accept');

Route::delete('/ticket/{id}', [TeamCreateCntroller::class, 'deleteTicket'])->name('ticket.delete');
Route::get('/admin/dashboard',[TeamCreateCntroller::class,'ticketCount'])->name('admin.dashboard');

//team leader

Route::get('/teamLeader/assign',[Team_leaderController::class,'index'])->name('teamLeader.showpage');

Route::get('/leader-tickets', [Team_leaderController::class, 'myTickets'])->name('leader.tickets');

Route::get('/ticket/delete/{id}', [Team_leaderController::class, 'delete'])->name('ticket.delete');
Route::get('/ticket/assign',[Team_leaderController::class,'showform'])->name('ticket.showform');
Route::post('/tikcets/assign',[Team_leaderController::class,'assign'])->name('ticket.assign');
Route::get('reject/{id}',[Team_leaderController::class,'reject'])->name('ticket.reject');

Route::get('/team-Leader/accept/{id}',[agentController::class,'accept'])->name('ticket.accept');


Route::get('/leader/my-team', [Team_leaderController::class, 'myTeam'])
    ->name('leader.myteam');
Route::get('/all-team-data',[Team_leaderController::class,'allTeam'])->name('all.dataTeam');

Route::post('/leader/tickets/{id}/status', [Team_leaderController::class, 'updateStatus'])->name('leader.status.update');

Route::delete('/ticket/delete/{id}', [TeamCreateCntroller::class, 'deleteTicket'])->name('ticket_leader.delete');
//agent

Route::get('/agent/assign',[agentController::class,'index'])->name('agent.showpage');
Route::get('/agent/accept/{id}',[agentController::class,'accept'])->name('agent.accept');
Route::get('/ticket/reject/{id}',[agentController::class,'reject'])->name('agent.reject');

Route::post('/chat/send/{customer_id}',[messageController::class,'sendMsg'])->name('chat.send');

Route::get('/chat/getMsg/{user_id}',[messageController::class,'showMsg'])->name('chat.get');

Route::post('/agent/status/{id}', [agentController::class, 'updateStatus'])->name('agent.status.update');

Route::get('agent/comment/list',[agentController::class,'getcomment'])->name('Comments.list');
Route::post('/agent/add/comments/{id}',[agentController::class,'addComment'])->name('addComments');
Route::get('/chat/index',[ChattestController::class,'index'])->name('chat.test');
Route::get('/chats', [messageController::class, 'index'])->name('chats.index');

Route::get('/chats/{id}', [messageController::class, 'openchat'])->name('chats.open');

Route::post('/chat/send', [messageController::class, 'sendmsg'])->name('chats.send');

Route::get('/chat/{customer_id}', [messageController::class, 'chat'])->name('agent.chat');


Route::post('/chat/send', [messageController::class, 'sendmsg'])
    ->name('chats.send');
Route::view('navbar','navbar');










Route::get('/signup', [SignupController::class, 'index']);
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');

Route::get('/login', [LoginController::class, 'index'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Password Reset
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [LoginController::class, 'password']);
Route::post('/forgot-password', [LoginController::class, 'forgot'])->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('rest-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', [LoginController::class, 'update_password'])->name('password.update');
/*
|--------------------------------------------------------------------------
| home page
|--------------------------------------------------------------------------
*/
 Route::get('/homepage', [LoginController::class, 'homepage'])->name('homepage');

/*
|--------------------------------------------------------------------------
| Permissions
|--------------------------------------------------------------------------
*/
Route::get('/permission', [PermissionController::class, 'showPermission'])->name('permission.show');
Route::post('/permission', [PermissionController::class, 'store'])->name('permission.add');

Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index');
Route::get('/permission/fetch', [PermissionController::class, 'fetch'])->name('permission.fetch');

Route::get('/permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
Route::post('/permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
Route::post('/permission/delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');

/*
|--------------------------------------------------------------------------
| Roles
|--------------------------------------------------------------------------
*/
Route::get('/role/create', [RoleController::class, 'showRole'])->name('role.show');
Route::post('/role/create', [RoleController::class, 'store'])->name('role.create');

Route::get('/role', [RoleController::class, 'index'])->name('role.index');
Route::get('/role/fetch', [RoleController::class, 'fetch'])->name('role.fetch');

Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
Route::get('/role/create', [RoleController::class, 'showrole'])->name('role.show');
Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');

Route::post('/role/delete/{id}', [RoleController::class, 'destory'])->name('role.destroy');

Route::get('/user', [RoleController::class, 'User_data'])->name('role.data');

Route::post('/role/user/{id}', [RoleController::class, 'role_assign'])->name('role.user');