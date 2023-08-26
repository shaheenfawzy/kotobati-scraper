<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta
		http-equiv="X-UA-Compatible"
		content="IE=edge"
	>
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1.0"
	>
	<title>Kotobati Scraper</title>

	@vite('resources/js/app.js')
</head>

<body>
	<div class="vh-100 container">
		<div class="vh-100 row align-items-center justify-content-center">
			<form
				class="col-8"
				action=""
			>
				<div class="input-group col-12">
					<div class="col-12 mb-3">
						<label
							class="form-label"
							for="bookInput"
						>Book url:</label>
						<input
							class="form-control"
							id="bookInput"
							type="bookInput"
							required
							placeholder="Enter Kotobati Book Url Here"
						>
					</div>
				</div>
				<button
					class="btn btn-primary col-12"
					type="submit"
				><i class="fa-solid fa-spider"></i> Start scraping</button>
			</form>

			<div
				class="col-8 d-none"
				id="bookInfo"
			>
				<p>Title: <span id="bookTitle"></span></p>
				<p>Author: <span id="bookAuthor"></span></p>
				<p>Language: <span id="bookLanguage"></span></p>
				<p>Pages Count: <span id="bookPagesCount"></span></p>
				<p>Size: <span id="bookSize"></span></p>

				<a
					class="btn btn-success col-12 d-none"
					id="downloadBtn"
					target=""
				><i class="fa-solid fa-file-download"></i> Download Book</a>
			</div>
		</div>
	</div>
</body>

</html>
