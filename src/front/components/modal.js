import axios from 'axios';
import querystring from 'querystring';
import { delay } from './helpers';

export default function() {
	const cache = cacheDOM();
	const template = wp.template( 'profile' );

	bindEvents();

	cache.articles.forEach( article => {
		let id = article.getAttribute( 'id' );
		id = parseInt( id.match( /\d+/ )[0], 10 );
		article.addEventListener( 'click', openModal( id ) );
	});

	function bindEvents() {
		cache.closeBtn.addEventListener( 'click', closeModal );
		cache.modal.addEventListener( 'click', maybeOpenModal );
	}

	function cacheDOM() {
		return {
			modal: document.querySelector( '.profile-modal' ),
			modalContainer: document.querySelector( '.profile-modal-container' ),
			modalContent: document.querySelector( '.profile-content' ),
			articles: Array.from( document.querySelectorAll( '.hentry' ) ),
			closeBtn: document.querySelector( '.close-modal' )
		};
	}

	function maybeOpenModal( e ) {
		e.preventDefault();

		const target = e.target;

		if ( ! target.classList.contains( 'next-link' ) ) {
			return;
		}

		const id = parseInt( e.target.getAttribute( 'data-id' ) );

		const data = {
			action: 'wpcct_get_post',
			nonce: WPCCT.ajax_nonce,
			id
		};

		axios.post( WPCCT.ajaxurl, querystring.stringify( data ) )
			.then( res => {
				const html = template( res.data );
				cache.modalContent.innerHTML = html;
			});
	}

	function openModal( id ) {

		return function( e ) {
			e.preventDefault();

			document.body.classList.add( 'modal-open' );
			cache.modal.classList.add( 'opened', 'loading' );
			cache.modalContainer.classList.add( 'animate-in' );

			delay( 600 )
				.then( () => cache.modalContainer.classList.remove( 'animate-in' ) );

			const data = {
				action: 'wpcct_get_post',
				nonce: WPCCT.ajax_nonce,
				id
			};

			axios.post( WPCCT.ajaxurl, querystring.stringify( data ) )
				.then( res => {
					const html = template( res.data );
					cache.modalContent.innerHTML = html;
					cache.modal.classList.remove( 'loading' );
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
	}
}