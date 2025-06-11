let video = document.getElementById("videoElement");
let useFrontCamera = true;
let stream;
let map;
let marker;
// Start Camera
function startCamera() {
navigator.mediaDevices.getUserMedia({
video: { facingMode: useFrontCamera ? "user" : "environment" }
}).then(mediaStream => {
stream = mediaStream;
video.srcObject = stream;
}).catch(error => {
console.error('Camera initialization error:', error);
alert('Unable to access the camera. Please check permissions and try again.');
});
}
// Switch Camera
function switchCamera() {
useFrontCamera = !useFrontCamera;
if (stream) {
stream.getTracks().forEach(track => track.stop());
}
startCamera();
}
// Stop Camera
function stopCamera() {
if (stream) {
stream.getTracks().forEach(track => track.stop());
}
}
// Capture Image
function capturePhoto() {
    let canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    let context = canvas.getContext("2d");
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    
    // Convert the captured image to Base64
    let imageData = canvas.toDataURL("image/png");
    
    // Remove the 'data:image/png;base64,' part from the Base64 string
    let base64Image = imageData.split(',')[1]; // Get the actual Base64 string
    
    return base64Image;  // Return the cleaned Base64 string
}
// Get Location
function getLocation() {
return new Promise((resolve, reject) => {
if ("geolocation" in navigator) {
navigator.geolocation.getCurrentPosition(
position => {
resolve({
latitude: position.coords.latitude,
longitude: position.coords.longitude
});
},
error => {
reject(error.message);
}
);
} else {
reject("Geolocation not supported by browser.");
}
});
}
function initializeMap(latitude, longitude) {
const userLocation = { lat: latitude, lng: longitude };
map = new google.maps.Map(document.getElementById("map"), {
center: userLocation,
zoom: 15,
});
marker = new google.maps.Marker({
position: userLocation,
map: map,
});
}
async function showCurrentLocationOnMap() {
try {
if ("geolocation" in navigator) {
navigator.geolocation.getCurrentPosition(
position => {
const latitude = position.coords.latitude;
const longitude = position.coords.longitude;
$("#locations").text(`${latitude}, ${longitude}`);
$("#latitude").val(latitude);
$("#longitude").val(longitude);
// Initialize the map
initializeMap(latitude, longitude);
},
error => {
console.error("Error fetching location:", error.message);
alert("Unable to fetch location. Please enable location services.");
}
);
} else {
alert("Geolocation is not supported by this browser.");
}
} catch (error) {
console.error("Error getting location:", error.message);
alert("An error occurred while fetching the location.");
}
}
// Submit Data
async function submitEntryData() {
try {
// Capture Image
let capturedImage = capturePhoto();
// Get Location
let location = await getLocation();
// Data Payload
let id=$("#empid").val();
let status=$("#status").val();
let payload = {
image: capturedImage,
latitude: location.latitude,
longitude: location.longitude,
eid:id,
status:status
};
$("#locations").text(location.latitude+','+location.longitude);
//console.log("Payload to Submit:", payload);
// Send Data to the Server
$.ajax({
    url: "private/attendence_function.php", // Change to your backend endpoint
    type: "POST",
    data: JSON.stringify(payload),
    contentType: "application/json",
    success: function (response) {
       // console.log(response);
        response = JSON.parse(response);
        if (response.status) {
        Swal.fire({
            icon: "success",
            title: response.message,
            showConfirmButton: false,
            timer: 1500 // 1.5 seconds
        }).then(function () {
            window.location.href = "index";
        });
    } else {
        Swal.fire({
            icon: "error",
            title: response.message,
            showConfirmButton: false,
            timer: 1500 // 1.5 seconds
        }).then(function () {
            window.location.href = "index";
        });
    }
        //document.write(response)
        //alert("Entry recorded successfully!");
        //$('#entryModal').modal('hide');
    },
    error: function (error) {
        console.error("Error submitting entry data:", error);
        alert("Failed to record entry.");
    }
});
} catch (error) {
console.error("Error capturing data:", error);
alert("Failed to capture data. " + error);
}
}
// // Event Listeners
// $('#entryModal').on('shown.bs.modal', function () {
// startCamera();
// showCurrentLocationOnMap();
// });
$('#entryModal').on('hidden.bs.modal', function () {
stopCamera();
});
$('#switchCamera').on('click', switchCamera);
// Capture and Submit Button
$('#capturePhoto').on('click', submitEntryData);


$(document).on("click", "#confirmpass",function() {
var pass=$("#inputPassword5").val();
var secu=$("#security").val();
$.ajax({
url: 'passverify.php',
type: 'post',
data: {password: pass, security:secu},
success: function (data) {
if (data==true) {
    //submitEntryData();
    $('#entryModal1').modal('hide');
 $('#entryModal1').on('hidden.bs.modal', function () {
    $("#entryModal").modal('show');
 });


// Event Listeners
$('#entryModal').on('shown.bs.modal', function () {
startCamera();
showCurrentLocationOnMap();
});


}else{
    alert("Please Give your correct Password.");
}

}
});
});