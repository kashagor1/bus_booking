<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Bus | NewBus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

   <style>
        footer.footer.mt-auto.py-3.bg-body-tertiary {
            background: gray !important;
        }

        span.text-body-secondary {
            color: white !important;
        }

        .section-with-background {
            background-image: url('https://img.freepik.com/free-vector/flat-background-world-tourism-day-celebration_23-2149582530.jpg?w=2000');
            background-size: cover;
            background-position: center;
            box-shadow: 0 2px 4px rgba(0, 0, 1, 0.2);
            filter: contrast(125%); /* Adjust the contrast percentage as desired */

        }

        p.col-md-8.fs-4 {
            color: #e7ff35;
            font-weight: 600;

            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Customize the shadow values as desired */

        }

        h1.display-5.fw-bold {
            color: #ffc107;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Customize the shadow values as desired */

        }

        .sicon {
            font-size: 1.5rem;
        }

        .custom-input {
            border: none;
            border-bottom: 1px solid lightgray;
            transition: border-bottom-color 0.3s ease-in-out;
            outline: none;
        }

        .custom-input:focus {
            border-bottom-color: blue;
        }

        .flex-fill.form_header {
            font-size: 1rem;
            font-weight: 600;
            color: gray;
            text-transform: capitalize;
        }

        .my-form {
            display: contents;
        }

        .b_submit_button {
            font-weight: 600;
        }

        #search-results {
            max-height: 50px;
            /* Set a fixed height */
            overflow-y: auto;
            /* Enable vertical scrolling if necessary */
        }

        footer.container {
            width: auto;
            max-width: 680px;
            padding: 0 15px;
        }
        
.card.px-3 {
    margin-top: -4.5rem;
}
.custom-input::-webkit-inner-spin-button,
.custom-input::-webkit-calendar-picker-indicator {
  display: none;
  -webkit-appearance: none;
}

.custom-input {
  padding-right: 16px; /* Add some padding to make room for the date value */
}
ul {  
list-style-type: none;  
 
}  

table {
    border-collapse: collapse;
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
  }
  td {
    padding: 5px;
    text-align: center;
    vertical-align: middle;
    /* width: 20%; */
  }
  button {
    width: 100%;
    height: 2.5rem;
    margin: 5px;
    padding: 0;
    border: none;
    background-color: #e6e6e6;
    color: #444;
    font-size: 12px;
    font-weight: bold;
    text-align: center;
    text-shadow: none;
    cursor: pointer;
    outline: none;
    border-radius: 5px;
    transition: all 0.3s ease;
  }
  button.available:hover {
    background-color: #bfbfbf;
    color: white;
    transform: scale(1.1);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  }
  button.selected {
    background-color: #8bc34a;
    color: white;
  }
  button.unavailable {
    background-color: #444;
    color: white;
    cursor: not-allowed;
  }
.seatList{
  width: 25%;
}
.lsb{
  font-size: 11px;
}
.container.checklogin {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
}

h2 {
  text-align: center;
}

.form-container {
  margin-top: 20px;
}

.tabs {
  display: flex;
  justify-content: center;
}

.tab {
  margin: 0 10px;
  padding: 5px 10px;
  background-color: lightgray;
  border: none;
  cursor: pointer;
}

.form {
  display: flex;
  flex-direction: column;
}

input[type="text"],
input[type="email"],
input[type="tel"],
input[type="password"] {
  margin-bottom: 10px;
  padding: 5px;
}

button[type="submit"] {
  padding: 10px;
  background-color: lightblue;
  border: none;
  cursor: pointer;
}


  </style>
</head>

<body>
<main class="container">
