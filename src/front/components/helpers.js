import axios from 'axios';
import querystring from 'querystring';

export const delay = ( t = 300 ) => {
	return new Promise( ( resolve ) => {
		setTimeout( () => resolve(), t );
	})
};

export const api = url => data => axios.post( url, querystring.stringify( data ) );

export const cacheDOM = document => ({
	modal: document.querySelector( '.profile-modal' ),
	modalContainer: document.querySelector( '.profile-modal.container' ),
	modalContent: document.querySelector( '.profile-content' ),
	modalPost: document.querySelector( '.profile-content .post' ),
	articles: Array.from( document.querySelectorAll( '.hentry' ) ),
	closeBtn: document.querySelector( '.close-modal' ),
});

export const createPostDataDefaults = ( action, nonce ) => ({ action, nonce });

export const bindArticleEvents = articles => cb => {

	articles.forEach( article => {
		let id = article.getAttribute( 'id' );
		id = parseInt( id.match( /\d+/ )[0], 10 );
		article.addEventListener( 'click', cb( id ) );
	});
};

export const findFocusableElements = modal => Array.from( modal.querySelectorAll('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex="0"]') );
