const url = 'https://movie-database-alternative.p.rapidapi.com/?s=Avengers%20Endgame&r=json&page=1';
const options = {
	method: 'GET',
	headers: {
		'x-rapidapi-key': 'Sign Up for Key',
		'x-rapidapi-host': 'movie-database-alternative.p.rapidapi.com'
	}
};

try {
	const response = await fetch(url, options);
	const result = await response.text();
	console.log(result);
} catch (error) {
	console.error(error);
}

