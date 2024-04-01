(function () {
  var myElement = document.getElementById("simple-bar");
  new SimpleBar(myElement, { autoHide: true });
})();

// $(document).ready(function() {
//   $('.status-select').on('change', function() {
//     var selectedValue = $(this).val();
//     var catId = $(this).data('cat-id');
//     //alert(catId);
//       // Toggle the status
//       var newStatus = (selectedValue === 'active') ? '0' : '1';
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/categories/' + catId + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });


// $(document).ready(function() {
//   $('.select').on('change', function() {
//     var selectedValue = $(this).val();
//     var Id = $(this).data('adv-id');
//     //alert(Id);
//       // Toggle the status
//       var newStatus = (selectedValue === 'active') ? '0' : '1';
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/sales/' + Id + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });


// $(document).ready(function() {
//   $('.act-select').on('change', function() {
//     var selectedValue = $(this).val();
//     var Id = $(this).data('mem-id');
//     //alert(catId);
//       // Toggle the status
//       var newStatus = (selectedValue === 'active') ? '0' : '1';
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/memberships/' + Id + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });


// $(document).ready(function() {
//   $('.qus-select').on('change', function() {
//     var selectedValue = $(this).val();
//     var Id = $(this).data('qu-id');
//     //alert(catId);
//       // Toggle the status
//       var newStatus = (selectedValue === 'active') ? '2' : '1';
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/reports/' + Id + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });


// $(document).ready(function() {
//   $('.ad-select').on('change', function() {
//     var selectedValue = $(this).val();
//     var Id = $(this).data('ad-id');
//     //alert(catId);
//       // Toggle the status
//       var newStatus = (selectedValue === 'active') ? '0' : '1';
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/advertises/' + Id + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });

// $(document).ready(function() {
//   $('.sell-select').on('change', function() {
//     var selectedValue = $(this).val();
//     var Id = $(this).data('sell-id');
//     //alert(catId);
//       // Toggle the status
//       var newStatus = (selectedValue === 'active') ? '0' : '1';
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/sellers/' + Id + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });


// $(document).ready(function() {
//   $('.part-select').on('change', function() {
//     var selectedValue = $(this).val();
//     var Id = $(this).data('part-id');
//     //alert(Id);
//       // Toggle the status
//       var newStatus;
//       if (selectedValue === 'active') {
//           newStatus = '1';
//       } else if (selectedValue === 'pending') {
//           newStatus = '0';
//       } else if (selectedValue === 'solved') {
//           newStatus = '2';
//       } else if (selectedValue === 'inactive') {
//           newStatus = '3';
//       } else {
       
//         newStatus = '1'; 
//     }
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/request-parts/' + Id + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });


// $(document).ready(function() {
//   $('.bid-select').on('change', function() {
//     var selectedValue = $(this).val();
//     var Id = $(this).data('bid-id');
//     //alert(Id);
//       // Toggle the status
//       var newStatus;
//       if (selectedValue === 'approved') {
//           newStatus = '0';
//       } else if (selectedValue === 'winning') {
//           newStatus = '1';
//       } else if (selectedValue === 'cancel') {
//           newStatus = '2';
//       } else {
       
//         newStatus = '0'; 
//     }
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/bidoffer/' + Id + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });


// $(document).ready(function() {
//   $('.delivery-select').on('change', function() {
//     var selectedValue = $(this).val();
//     var Id = $(this).data('del-id');
//     //alert(Id);
//       // Toggle the status
//       var newStatus = (selectedValue === 'delivered') ? '0' : '1';
      
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/saleorder/' + Id + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });


// $(document).ready(function() {
//   $('.order-select').on('change', function() {
//     var selectedValue = $(this).val();
//     var Id = $(this).data('ord-id');
//     //alert(Id);
//       // Toggle the status
//       var newStatus;
//       if (selectedValue === 'new order') {
//           newStatus = '0';
//         } else if (selectedValue === 'confirmed order') {
//             newStatus = '1';
//         } else if (selectedValue === 'completed order') {
//             newStatus = '2';
//         } else if (selectedValue === 'shipped order') {
//           newStatus = '3';
//         } else if (selectedValue === 'cancel Order') {
//          newStatus = '4';
//       }else {
       
//         newStatus = '0'; 
//       }
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/saleorder/' + Id + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });

// $(document).ready(function() {
//   $('.news-select').on('change', function() {
//     var selectedValue = $(this).val();
//     var Id = $(this).data('news-id');
//     //alert(Id);
//       // Toggle the status
//       var newStatus = (selectedValue === 'Confirmed') ? '0' : '1';
      
//        //alert('newStatus');
//       // Send Ajax request
//       $.ajax({
//           url: '/admin/newsletters/' + Id + '/update-status',
//           type: 'POST',
//           data: {

//               status: newStatus
//           },

//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },


//           success: function(response) {
//               // Update the displayed status
//               $('.status', $(this).closest('p')).text(response.status);
//               alert(response.message);
//           },
//           error: function(xhr) {
//               alert('Error: ' + xhr.responseText);
//           }
//       });
//   });
// });
