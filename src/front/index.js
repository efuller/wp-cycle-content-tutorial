/**
 * JavaScript Entry Point.
 */

// Import styles.
import './scss/main.scss';
import Modal from './components/modal';

document.addEventListener( 'DOMContentLoaded', () => {
	Modal( document, window.WPCCT );
});
