<div>
@include('../switcher')
<table  style="border: none;">
  <thead>
	<tr>
	  <th>Booking Date</th>
	  <th>ID Customer</th>
	  <th>Komplain</th>
	  <th>Tipe Servis</th>
	</tr>
  </thead>
  <tbody>
	<tr>
	  <td class="booking_date">{{$booking_date}}</td>
	  <td class="id_customer">{{$id_customer}}</td>
	  <td class="complaint">{{$complaint}}</td>
	  <!--<td class="service_type"></td> -->
	</tr>
  </tbody>
</table>
</div>