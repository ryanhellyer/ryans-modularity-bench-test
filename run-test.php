<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bench test of Modularity vs old school WordPress functions</title>
    <style>
        body {
            padding: 10px;
        }
        * {
            font-family: sans-serif;
        }
        h1 {
            font-size: 1.5em;
        }
        #responses {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            height: 300px;
            overflow-y: auto;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Bench test of Modularity vs old school WordPress functions</h1>
    <p>
    <?php
	if ('delete' === $_GET['runTest']) {
		delete_option('modularityTest');
		delete_option('oldSchoolTest');

		echo '<p>Deleted previous data.</p>';
	} else {
		echo '<a href="/?runTest=delete">Delete old data</a>';
	}
	?>
	</p>
    <button id="pauseButton">Pause</button>
    <div id="responses"></div>

    <script>
        let isPaused = false;
        document.getElementById('pauseButton').addEventListener('click', function() {
            isPaused = !isPaused; // Toggle the pause state
            this.textContent = isPaused ? 'Resume' : 'Pause'; // Change button text accordingly
        });

        function makeRequest(url) {
            if (isPaused) return; // Prevent new requests from being made if paused

            const xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    displayResponse(xhr.responseText);
                } else {
                    displayResponse('Failure from ' + url + ': ' + xhr.statusText);
                }
                setTimeout(() => makeRequest(url), isPaused ? null : 0); // Delayed recursive call to handle continuous requests
            };
            xhr.onerror = function() {
                displayResponse('Error making the request to ' + url);
                setTimeout(() => makeRequest(url), isPaused ? null : 0); // Delayed retry on error
            };
            xhr.send();
        }

        function displayResponse(message) {
            const responses = document.getElementById('responses');
            responses.innerHTML = '<p>' + message + '</p>';
        }

		const random = Math.random();
		if (random < 0.5) {
			makeRequest('/?oldSchool');
			makeRequest('/?modularity');
		} else {
			makeRequest('/?modularity');
			makeRequest('/?oldSchool');
		}
    </script>
</body>
</html>