import axios from 'axios';
import querystring from 'querystring';

export const delay = ( t = 300 ) => {
	return new Promise( ( resolve ) => {
		setTimeout( () => resolve(), t );
	})
};

export const api = url => data => axios.post( url, querystring.stringify( data ) );

