<table>
  @php
    $days_long = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; 
  @endphp
  <thead>
    <tr>
      <th>Day</th>
      <th>Opens</th>
      <th>Closes</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < 7; $i++)
    <tr>
      <td>{{$days_long[$i]}}</td>
      @if(isset($menu->operatinghours[$i]))
        <td>{{date('g:i a', strtotime($menu->operatinghours[$i]->opening_time))}}</td>
        <td>{{date('g:i a', strtotime($menu->operatinghours[$i]->closing_time))}}</td>
      @endif
    </tr>
    @endfor
  </tbody>
</table>
