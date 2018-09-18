import { delay, api } from './helpers';

export default function( globals = {} ) {
	const cache = cacheDOM();
	const template = wp.template( 'profile' );
	const data = {
		action: 'wpcct_get_post',
		nonce: globals.ajax_nonce,
	};
	const apiCall = api( globals.ajaxurl );

	cache.articles.forEach( article => {
		let id = article.getAttribute( 'id' );
		id = parseInt( id.match( /\d+/ )[0], 10 );
		article.addEventListener( 'click', openModal( id ) );
	});

	function bindEvents() {
		cache.closeBtn.addEventListener( 'click', closeModal );
		cache.modal.addEventListener( 'click', maybeOpenModal );
		cache.modal.addEventListener( 'keydown', handleKeyDown );
	}

	function handleKeyDown( e ) {
		const KEY_TAB = 9;

		function handleBackwardTab() {
			if ( document.activeElement === cache.focusable[0] ) {
				e.preventDefault();
				cache.focusable[cache.focusable.length -1].focus();
			}
		}
		function handleForwardTab() {
			if ( document.activeElement === cache.focusable[cache.focusable.length -1]) {
				e.preventDefault();
				cache.focusable[0].focus();
			}
		}

		switch(e.keyCode) {
			case KEY_TAB:
				if ( cache.focusable.length === 1 ) {
					e.preventDefault();
					break;
				}

				if ( e.shiftKey ) {
					handleBackwardTab();
				} else {
					handleForwardTab();
				}

				break;
			default:
				break;
		} // end switch
	}

	function findFocusableElements() {
		return Array.from( cache.modal.querySelectorAll('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex="0"]') );
	}

	function cacheDOM() {
		return {
			modal: document.querySelector( '.profile-modal' ),
			modalContainer: document.querySelector( '.profile-modal.container' ),
			modalContent: document.querySelector( '.profile-content' ),
			modalPost: document.querySelector( '.profile-content .post' ),
			articles: Array.from( document.querySelectorAll( '.hentry' ) ),
			closeBtn: document.querySelector( '.close-modal' ),
		};
	}

	function maybeOpenModal( e ) {
		e.preventDefault();

		const target = e.target;

		if ( ! target.classList.contains( 'next-link' ) ) {
			return;
		}

		const id = parseInt( e.target.getAttribute( 'data-id' ) );
		document.querySelector( '.profile-content .post').classList.add( 'animate-left' );

		delay( 500 )
			.then( () => document.querySelector( '.profile-content .post' ).classList.remove( 'animate-left' ) );

		const postData = { ...data, id };

		apiCall( postData )
			.then( res => {
				const html = template( res.data );
				cache.modalContent.innerHTML = html;
				cache.focusable = findFocusableElements();
				document.querySelector( '.profile-content .post').classList.add( 'animate-right' );
				cache.focusable[0].focus();
				delay( 500 )
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

			delay( 600 )
				.then( () => cache.modalContainer.classList.remove( 'animate-in' ) );

			const postData = { ...data, id };

			apiCall( postData )
				.then( res => {
					const html = template( res.data );
					cache.modalContent.innerHTML = html;
					cache.focusable = findFocusableElements();
					debugger;
					cache.modal.classList.remove( 'loading' );
					cache.focusable[0].focus();
				});
		};
	}

	function closeModal( e ) {
		e.preventDefault();

		cache.modalContainer.classList.add( 'animate-out' );

		delay( 600 )
			.then( () => {
				document.body.classList.remove( 'modal-open' );
				cache.modal.classList.remove( 'opened', 'loading' );
				cache.modalContainer.classList.remove( 'animate-out' )
			});

		cache.modalContent.innerHTML = '';
		cache.focusBefore.focus();
	}

	bindEvents();
}