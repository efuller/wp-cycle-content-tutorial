import axios from 'axios';
import querystring from 'querystring';

/**
 * Delay - a nicer setTimeout.
 * @param t
 * @returns {Promise}
 */
export const delay = ( t = 300 ) => {
	return new Promise( ( resolve ) => {
		setTimeout( () => resolve(), t );
	})
};

/**
 * Make an API call.
 * @param url
 * @returns {function : AxiosPromise}
 */
export const api = url => data => axios.post( url, querystring.stringify( data ) );

export const cacheDOM = document => ({
	modal: document.querySelector( '.profile-modal' ),
	modalContainer: document.querySelector( '.profile-modal.container' ),
	modalContent: document.querySelector( '.profile-content' ),
	modalPost: document.querySelector( '.profile-content .post' ),
	articles: Array.from( document.querySelectorAll( '.hentry' ) ),
	closeBtn: document.querySelector( '.close-modal' ),
});

/**
 * Post data object creator.
 * @param action
 * @param nonce
 * @returns {{action: *, nonce: *}}
 */
export const createPostDataDefaults = ( action, nonce ) => ({ action, nonce });

/**
 * Bind opening the modal on articles.
 * @param articles
 * @returns {Function}
 */
export const bindArticleEvents = articles => cb => {

	articles.forEach( article => {
		let id = article.getAttribute( 'id' );
		id = parseInt( id.match( /\d+/ )[0], 10 );
		article.addEventListener( 'click', cb( id ) );
	});
};

/**
 * Create an array of focusable elements.
 * @param modal
 * @returns {any[]}
 */
export const findFocusableElements = modal => Array.from( modal.querySelectorAll('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex="0"]') );
