<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontController@index')->name('home');

Route::get('/terms-and-conditions', 'FrontController@terms')->name('terms');

Route::get('/privacy-policy', 'FrontController@privacyPolicy')->name('privacy-policy');

Route::get('/events/search', 'FrontController@searchEvent')->name('event.search');

Route::get('/events/tags/{tag}', 'FrontController@getTag')->name('event.tags');

Route::get('/events/{slug}/view', 'FrontController@getEvent')->name('event.view');

Route::get('/events/{slug}/attend', 'FrontController@attendEvent')->name('user.event.attend');

Route::get('/events/{slug}/attendees', 'FrontController@getAttendees')->name('user.event.attendees');

Route::get('/events/{slug}/discussion', 'FrontController@getDiscussion')->name('user.event.discussion');

Route::post('/events/{slug}/attend', 'FrontController@attendEvent');

Route::post('/events/{slug}/like', 'FrontController@likeEvent')->name('event.like');

Route::post('/events/{slug}/comment', 'FrontController@postDiscussion')->name('event.comment');

Route::get('/users/{username}/profile/view', 'FrontController@getProfile')->name('user.other-profile.view');

Route::get('/user/{username}/events/attending', 'FrontController@getEventsAttending')->name('user.events.attending');

Route::get('/about', 'FrontController@getAboutUs')->name('about-us');

Route::get('/contact-us', 'FrontController@getContactUs')->name('contact-us');

Route::get('/dashboard', 'BackController@getDashboard')->name('dashboard');

Route::get('/account-suspended', 'FrontController@getSuspended')->name('suspended');

Route::post('/password/change', 'BackController@updatePassword')->name('password.change');

Route::post('/account/update', 'BackController@updateAccount')->name('account.update');

Route::post('/user/login', 'FrontController@login')->name('user.login');

Route::get('/user/last-seen/update', 'BackController@updateLastSeen')->name('user.last-seen.update');

Route::get('/notifications/count/get', 'BackController@getNotifications')->name('user.notifications.count');

Route::get('/messages/count/get', 'BackController@getMessageCount')->name('user.messages.count');

Auth::routes();

// Admin routes
Route::group(['prefix' => 'admin'], function(){
	Route::get('/dashboard', 'AdminController@getDashboard')->name('admin.dashboard');

	Route::get('/transactions', 'AdminController@getTransactions')->name('admin.transactions');

	Route::get('/account', 'AdminController@getAccount')->name('admin.account');

	Route::get('/events', 'AdminController@getEvents')->name('admin.events');
	Route::get('/events/active', 'AdminController@getActiveEvents')->name('admin.events.active');
	Route::get('/events/past', 'AdminController@getPastEvents')->name('admin.events.past');
	Route::get('/events/featured', 'AdminController@getFeaturedEvents')->name('admin.events.featured');
	Route::get('/events/cancelled', 'AdminController@getCancelledEvents')->name('admin.events.cancelled');
	Route::get('/events/closed', 'AdminController@getClosedEvents')->name('admin.events.closed');

	Route::post('/events/{slug}/close', 'AdminController@closeEvent')->name('admin.event.close');
	Route::post('/events/{slug}/withdraw', 'AdminController@withdrawEventCash')->name('admin.event.withdraw');
	
	Route::get('/events/{slug}/view', 'AdminController@getEvent')->name('admin.event');
	Route::get('/events/{slug}/attendees', 'AdminController@getEventAttendees')->name('admin.event.attendees');


	Route::get('/admins/create', 'AdminController@createAdmin')->name('admin.create-admin');
	Route::post('/admins/create', 'AdminController@postCreateAdmin')
	;
	Route::get('/admins', 'AdminController@getAdmins')->name('admin.admins');
	Route::get('/admins/{username}/view', 'AdminController@getAdmin')->name('admin.admin');

	Route::get('/users', 'AdminController@getUsers')->name('admin.users.active');
	Route::get('/users/suspended', 'AdminController@getSuspendedUsers')->name('admin.users.suspended');
	Route::get('/users/{username}/view', 'AdminController@getUser')->name('admin.user');
	Route::get('/users/{username}/events', 'AdminController@getUserEvents')->name('admin.user.events');
	Route::get('/users/{username}/events/attended', 'AdminController@getUserEventsAttended')->name('admin.user.events.attended');
	Route::post('/users/{username}/activate', 'AdminController@activateUser')->name('admin.user.activate');
	Route::post('/users/{username}/deactivate', 'AdminController@suspendUser')->name('admin.user.suspend');

	Route::post('/users/{username}/close', 'AdminController@closeAccount')->name('admin.user.close');
	Route::post('/users/{username}/reopen', 'AdminController@reopenAccount')->name('admin.user.reopen');

	Route::get('/site-settings', 'AdminController@getSiteSettings')->name('admin.site-settings');
	
	Route::get('/account/settings', 'AdminController@getSettings')->name('admin.account.settings');
	Route::post('/account/info/update', 'AdminController@postUpdateAdmin')->name('admin.info.update');
	Route::post('/account/password/update', 'AdminController@postUpdatePassword')->name('admin.password.update');

	Route::post('/site-settings/gateways/update', 'AdminController@postUpdateGateways')->name('admin.gateways.update');
	Route::post('/site-settings/general/update', 'AdminController@postUpdateGeneralSettings')->name('admin.general.update');
	Route::post('/site-settings/emails/update', 'AdminController@postUpdateEmailSettings')->name('admin.site-settings.emails.update');


});

// Manager routes
Route::group(['prefix' => 'manager'], function(){
	Route::get('/dashboard', 'ManagerController@getDashboard')->name('manager.dashboard');
});

// User routes
Route::group(['prefix' => 'user'], function(){
	Route::get('/dashboard', 'UserController@getDashboard')->name('user.dashboard');
	
	
	Route::get('/profile', 'UserController@getMyProfile')->name('user.profile');
	Route::get('/card', 'UserController@getCard')->name('user.card');
	Route::get('/engage', 'UserController@getEngage')->name('user.engage');
	Route::get('/settings', 'UserController@getSettings')->name('user.settings');
	
	Route::post('/card/{id}/update', 'UserController@updateCard')->name('user.card.update');
	Route::post('/card/{id}/background/update', 'ImageController@updateCardBackground')->name('user.card-background.update');
	Route::post('/card/{id}/thumbnail/update', 'ImageController@updateCardThumbnail')->name('user.card-thumbnail.update');

	Route::post('/user/image/update', 'ImageController@updateUserImage')->name('user.user-image.update');
	
	Route::post('/events/{id}/banner/update', 'ImageController@updateEventBanner')->name('user.event-banner.update');
	Route::post('/events/{slug}/update', 'UserController@updateEvent')->name('user.event.update');

	Route::get('/event/{slug}/ticket/{id}/print', 'UserController@printTicket')->name('user.ticket.print');
	
	Route::post('/events/{slug}/feature', 'UserController@featureEvent')->name('user.feature');

	Route::get('/events/{slug}/feature/process', 'UserController@processFeaturedEvent')->name('user.feature-process');

	Route::get('/events/{id}/{type}/checkout', 'UserController@eventCheckout')->name('user.checkout');
	
	Route::post('/events/{id}/checkout/mpesa/process', 'UserController@processMpesa')->name('user.checkout.mpesa');
	Route::get('/events/{id}/checkout/cc/process', 'UserController@processCC')->name('user.checkout.cc');
	

	Route::get('/events/requests', 'UserController@getEventRequests')->name('user.event-requests');
	Route::post('/events/requests/{id}/approve', 'UserController@approveEventRequest')->name('user.event.approve');
	Route::post('/events/requests/{id}/reject', 'UserController@rejectEventRequest')->name('user.event.reject');
	
	Route::post('/events/social-link/{slug}/add', 'UserController@addSocialLink')->name('social-link.add');
	Route::post('/events/social-link/{id}/delete', 'UserController@deleteSocialLink')->name('social-link.delete');

	Route::post('/events/sponsor/{slug}/add', 'UserController@addSponsor')->name('event.sponsor.add');
	Route::post('/events/sponsor/{id}/delete', 'UserController@deleteSponsor')->name('event.sponsor.delete');


	Route::post('/contacts/add', 'UserController@addContact')->name('user.contact.add');
	Route::post('/contacts/{id}/delete', 'UserController@deleteContact')->name('user.contact.delete');
	Route::post('/event/profile/update', 'UserController@updateEventProfile')->name('user.event-profile.update');
	
	Route::post('/profile/bio/update', 'UserController@updateProfileBio')->name('user.profile-bio.update');

	//////////////My Profile

	Route::post('/profile/memberships/add', 'UserController@addMembership')->name('user.membership.add');
	Route::post('/profile/memberships/{id}/update', 'UserController@updateMembership')->name('user.membership.update');
	Route::post('/profile/memberships/{id}/delete', 'UserController@deleteMembership')->name('user.membership.delete');

	Route::post('/profile/awards/add', 'UserController@addAward')->name('user.award.add');
	Route::post('/profile/awards/{id}/update', 'UserController@updateAward')->name('user.award.update');
	Route::post('/profile/awards/{id}/delete', 'UserController@deleteAward')->name('user.award.delete');
	
	Route::post('/profile/hobbies/add', 'UserController@addHobby')->name('user.hobby.add');
	Route::post('/profile/hobbies/{id}/update', 'UserController@updateHobby')->name('user.hobby.update');
	Route::post('/profile/hobbies/{id}/delete', 'UserController@deleteHobby')->name('user.hobby.delete');

	Route::post('/profile/work-experiences/add', 'UserController@addWorkExperience')->name('user.work-experience.add');
	Route::post('/profile/work-experiences/{id}/update', 'UserController@updateWorkExperience')->name('user.work-experience.update');
	Route::post('/profile/work-experiences/{id}/delete', 'UserController@deleteWorkExperience')->name('user.work-experience.delete');

	Route::post('/profile/references/add', 'UserController@addReference')->name('user.reference.add');
	Route::post('/profile/references/{id}/update', 'UserController@updateReference')->name('user.reference.update');
	Route::post('/profile/references/{id}/delete', 'UserController@deleteReference')->name('user.reference.delete');

	Route::post('/profile/skills/add', 'UserController@addSkill')->name('user.skill.add');
	Route::post('/profile/skills/{id}/update', 'UserController@updateSkill')->name('user.skill.update');
	Route::post('/profile/skills/{id}/delete', 'UserController@deleteSkill')->name('user.skill.delete');

	Route::post('/profile/achievments/add', 'UserController@addAchievement')->name('user.achievment.add');
	Route::post('/profile/achievments/{id}/update', 'UserController@updateAchievement')->name('user.achievment.update');
	Route::post('/profile/achievments/{id}/delete', 'UserController@deleteAchievement')->name('user.achievment.delete');
	
	Route::post('/profile/education/add', 'UserController@addEducation')->name('user.education.add');
	Route::post('/profile/education/{id}/update', 'UserController@updateEducation')->name('user.education.update');
	Route::post('/profile/education/{id}/delete', 'UserController@deleteEducation')->name('user.education.delete');

	///////End of My Profile

	Route::get('/my-events', 'UserController@getMyEvents')->name('user.my-events');

	Route::get('/booked-events', 'UserController@getBookedEvents')->name('user.booked-events');
	
	Route::get('/my-events/create', 'UserController@getCreateEvent')->name('user.event.add');
	Route::post('/my-events/create', 'UserController@postCreateEvent');
	
	Route::get('/my-events/{slug}/view', 'UserController@getEvent')->name('user.event.view');
	Route::post('/my-events/{slug}/update', 'UserController@updateEvent')->name('user.event.update');

	Route::post('/my-events/{slug}/delete', 'UserController@deleteEvent')->name('user.event.delete');

	Route::post('/user/{username}/card/request', 'UserController@requestCard')->name('user.card.request');
	Route::post('/card/{id}/request/approve', 'UserController@approveCardRequest')->name('user.card.request.approve');
	Route::post('/card/{id}/request/decline', 'UserController@declineCardRequest')->name('user.card.request.decline');
	
	Route::get('/messages', 'UserController@getConversations')->name('user.messages');
	Route::get('/conversation/{recepient}/view', 'UserController@newMessage')->name('user.message.new');
	Route::post('/conversation/{recepient}/view', 'UserController@postMessage');

	Route::get('/my-cards', 'UserController@getMyCards')->name('user.my-cards');
	Route::get('/card/requests', 'UserController@getCardRequests')->name('user.card-requests');
	Route::get('/users/cards/mine', 'UserController@getPeopleWithMyCard')->name('user.people-with-my-card');

	Route::get('/notifications/{id}/view', 'UserController@getNotification')->name('user.notification.get');
	Route::get('/notifications', 'UserController@getNotifications')->name('user.notifications.get');

	Route::get('/transactions', 'UserController@getTransactions')->name('user.transactions');

	Route::post('event/{slug}/tags/create', 'UserController@addEventTag')->name('user.add-tag');
	Route::post('/tags/{id}/delete', 'UserController@deleteEventTag')->name('user.delete-tag');

	Route::post('/settings/account/close', 'UserController@closeAccount')->name('user.close-account');

	Route::get('/payment/paypal/{id}/{type}/request', 'PaymentsController@makePaypalPayment')->name('user.paypal.request');
	Route::get('/payment/paypal/{type}/verify', 'PaymentsController@verifyPaypalPayment')->name('user.paypal.verify');

	Route::post('/payment/mpesa/{id}/{type}/request', 'PaymentsController@makeMpesaPayment')->name('user.mpesa.request');
	Route::post('/payment/mpesa/{id}/{type}/save', 'PaymentsController@saveMpesaRequest')->name('user.mpesa.save');
});


