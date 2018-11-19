<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Gather input="dtmf" timeout="2" numDigits="1" action="{{URL::to('/api/completetransaction/' . $id)}}">
        <Say voice="alice" language="en-AU">{{$order}} Please press 1 to accept or 2 to decline this order.</Say>
    </Gather>
</Response>
