<table class="table table-bordered" id="award">
    <thead>
        <tr>
     
            <th>Name</th>

            <th>Strand</th>

            <th>GWA</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @php
            $first = true; 
        @endphp
        @foreach($subjectAverages as $average)
            <tr>

              @if($showResult)
                @if ($first)
                    
                    <td>{{ $average->firstname }} {{ $average->lastname }}</td>
                    <td>{{$average->strand}} - {{ $average->level }}</td>
                    <td>{{ number_format($result)  }}</td>
                    
                     <td> @if(number_format($result) >= 98  && number_format($result <= 100)  ))

                      With Highest Honors

                      @elseif(number_format($result) >= 95  && number_format($result <= 97))

                      High Honors

                      
                      @elseif( number_format($result >= 90 && number_format($result <= 94.99)  ))

                      With Honors

                      @endif
                     </td>
                    @php
                        $first = false; 
                    @endphp

                    @else



                    @endif
                @endif
               
            </tr>
        @endforeach
    </tbody>
</table>