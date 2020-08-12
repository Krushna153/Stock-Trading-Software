// Sorts table depending on column
function sortTable(n) {
    // initialize our variables we will use to keep track of rows and direction
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myStocks"); // Grab our table
    switching = true;
    dir = "asc"; // First time clicked will be in asc order
    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("TR");
        // iterate through all of our rows and grab the current and next element.
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n]; // Current element.
            y = rows[i + 1].getElementsByTagName("TD")[n]; // Next element.
            // Check for ASC order
            if (dir == "asc") {
                // If n is less than two then sort alphabetically.
                if (n < 2) {
                    // Convert each element to lowercase for comparison.
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        // If current is larger than next switch
                        shouldSwitch = true;
                        break;
                    }
                }
                // If n is 2-5 sort numerically.
                else if (n > 1 && n < 6) {
                    // Convert elements to float for comparison.
                    if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                        // If current is larger than next switch
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    // if n is greater than 5 sorting dates
                    // Since we cant compare elements in original for we must convert to
                    // javascript's Date objects for comparison.
                    var day1 = x.innerHTML.toString();
                    var day2 = y.innerHTML.toString();
                    // Parse date to correct Date object format.
                    var date1 = new Date(day1.replace(/-/g, '/'));
                    var date2 = new Date(day2.replace(/-/g, '/'));
                    if (date1 > date2) {
                        // If current is larger than next switch.
                        shouldSwitch = true;
                        break;
                    }
                }
                // Desc direction
            } else if (dir == "desc") {
                // If n is less than two then sort alphabetically.
                if (n < 2) {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        // If current is smaller than next switch.
                        shouldSwitch = true;
                        break;
                    }
                }
                // If n is 2-5 sort numerically.
                else if (n > 1 && n < 6) {
                    if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
                        // If current is smaller than next switch.
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    // if n is greater than 5 sorting dates
                    // Since we cant compare elements in original for we must convert to
                    // javascript's Date objects for comparison.
                    var day1 = x.innerHTML.toString();
                    var day2 = y.innerHTML.toString();
                    // Parse date to correct Date object format.
                    var date1 = new Date(day1.replace(/-/g, '/'));
                    var date2 = new Date(day2.replace(/-/g, '/'));
                    if (date1 < date2) {
                        // If current is smaller than next switch.
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        }
        if (shouldSwitch) {
            // Since we selected to switch elements we do that here.
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Keep track of elements so that we dont keep going forever.
            switchcount++;
        } else {
            // Mark the end next time clicked will be desc.
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}