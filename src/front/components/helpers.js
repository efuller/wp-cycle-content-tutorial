export const delay = ( t = 300 ) => {
	return new Promise( ( resolve ) => {
		setTimeout( () => resolve(), t );
	})
};
