import * as helpers from './helpers';


export default function( document = {}, globals = {} ) {
	const cache = helpers.cacheDOM( document );
	const template = wp.template( 'profile' );
	const defaultPostData = helpers.createPostDataDefaults( 'wpcct_get_post', globals.ajax_nonce );
	const apiCall = helpers.api( globals.ajaxurl );

	function handleBackwardTab( e ) {
		if ( document.activeElement === cache.focusable[0] ) {
			e.preventDefault();
			cache.focusable[cache.focusable.length -1].focus();
		}
	}

	function handleForwardTab( e ) {
		if ( document.activeElement === cache.focusable[cache.focusable.length -1]) {
			e.preventDefault();
			cache.focusable[0].focus();
		}
	}

	function handleKeyDown( e ) {
		const KEY_TAB = 9;

		switch( e.keyCode ) {
			case KEY_TAB:
				if ( cache.focusable.length === 1 ) {
					e.preventDefault();
					break;
				}

				if ( e.shiftKey ) {
					handleBackwardTab( e );
				} else {
					handleForwardTab( e );
				}

				break;
			default:
				break;
		} // end switch
	}

	function maybeOpenModal( e ) {
		e.preventDefault();

		const target = e.target;

		if ( ! target.classList.contains( 'next-link' ) ) {
			return;
		}

		const id = parseInt( e.target.getAttribute( 'data-id' ) );
		document.querySelector( '.profile-content .post').classList.add( 'animate-left' );

		helpers.delay( 500 )
			.then( () => document.querySelector( '.profile-content .post' ).classList.remove( 'animate-left' ) );

		const postData = { ...defaultPostData, id };

		apiCall( postData )
			.then( res => {
				const html = template( res.data );
				cache.modalContent.innerHTML = html;
				cache.focusable = helpers.findFocusableElements( cache.modal );
				document.querySelector( '.profile-content .post').classList.add( 'animate-right' );
				cache.focusable[0].focus();
				helpers.delay( 500 )
					.then( () => document.querySelector( '.profile-content .post' ).classList.remove( 'animate-right' ) );
			});
	}

	function openModal( id ) {

		return function( e ) {
			e.preventDefault();

			document.body.classList.add( 'modal-open' );
			cache.modal.classList.add( 'opened', 'loading' );
			cache.modalContainer.classList.add( 'animate-in' );
			cache.focusBefore = document.activeElement;

			helpers.delay( 600 )
				.then( () => cache.modalContainer.classList.remove( 'animate-in' ) );

			const postData = { ...defaultPostData, id };

			apiCall( postData )
				.then( res => {
					const html = template( res.data );
					cache.modalContent.innerHTML = html;
					cache.focusable = helpers.findFocusableElements( cache.modal );
					cache.modal.classList.remove( 'loading' );
					cache.focusable[0].focus();
				});
		};
	}

	function closeModal( e ) {
		e.preventDefault();

		cache.modalContainer.classList.add( 'animate-out' );

		helpers.delay( 600 )
			.then( () => {
				document.body.classList.remove( 'modal-open' );
				cache.modal.classList.remove( 'opened', 'loading' );
				cache.modalContainer.classList.remove( 'animate-out' )
			});

		cache.modalContent.innerHTML = '';
		cache.focusBefore.focus();
	}

	function bindEvents() {
		helpers.bindArticleEvents( cache.articles )( openModal );
		cache.closeBtn.addEventListener( 'click', closeModal );
		cache.modal.addEventListener( 'click', maybeOpenModal );
		cache.modal.addEventListener( 'keydown', handleKeyDown );
	}

	bindEvents();
}