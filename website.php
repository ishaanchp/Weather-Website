<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "Users";

$con = mysqli_connect($server, $username, $password,$database);
if(!$con){
    die("connection to this database failed due to" . mysqli_connect_error());
}
$sql =  "SELECT * FROM Users";
$query= mysqli_query($con,$sql);
$result = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Weather App</title>
  <style>
    .dispusername{
      text-align: right;
    }

    body {
      font-family: Arial, sans-serif;
      text-align: center;
    }

    #form {
      margin-top: 50px;
    }

    input[type="text"] {
      padding: 10px;
      font-size: 16px;
    }

    button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: lightblue;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    #history {
      text-align: left;
      margin-top: 20px;
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
    }

    #history h3 {
      margin-top: 0;
    }

    #history ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    #history li {
      margin-bottom: 5px;
    }

    #history a {
      color: blue;
      text-decoration: underline;
      cursor: pointer;
    }

    #history a:hover {
      color: darkblue;
    }
  </style>
</head>

<body>
    <p class="dispusername">
    <?php
    echo "Logged in as: ".$result['Username'];
    ?><br>
    <a href="login.php">Logout</a>
    </p>
  <h1>Weather App</h1>
  <div id="form">
    <input type="text" id="city" placeholder="Enter city name" />
    <button id="submit">Submit</button>
  </div>
  <div id="output"></div>
  <div id="history">
    <h3>Search History:</h3>
    <ul id="history-list"></ul>
  </div>
</body>
<script>
  const submitBtn = document.querySelector("#submit");
  const cityInput = document.querySelector("#city");
  const outputDiv = document.querySelector("#output");
  const historyList = document.querySelector("#history-list");

  let searchHistory = [];

  submitBtn.addEventListener("click", function () {
    const city = cityInput.value;
    const apiKey = "4f9c96b92d324a71893a915f690c953d";
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}`;

    fetch(apiUrl)
      .then((response) => response.json())
      .then((data) => {
        const { main, name, sys, weather } = data;
        const icon = `https://openweathermap.org/img/wn/${weather[0]["icon"]}@2x.png`;
        const temperature = main.temp - 273.15;
        const country = sys.country;
        outputDiv.innerHTML = `
            <h2>Weather in ${name}, ${country}:</h2>
            <img src="${icon}" />
            <p>Temperature: ${temperature.toFixed(2)} &#8451;</p>
          `;
        if (!searchHistory.includes(name)) {
          searchHistory.push(name);

          // Add city to search history
          const historyItem = document.createElement("li");
          historyItem.innerHTML = `<a>${name}, ${country}</a>`;
          historyList.appendChild(historyItem);
        }

        // Set up click listener for history items
        const historyLinks = historyList.querySelectorAll("a");
        historyLinks.forEach((link) =>
          link.addEventListener("click", function () {
            const cityName = link.textContent.split(",")[0];
            cityInput.value = cityName;
            submitBtn.click();
          })
        );
      });
  });
</script>

</html>