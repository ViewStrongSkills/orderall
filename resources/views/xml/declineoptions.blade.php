<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Gather input="dtmf" timeout="3" numDigits="1" action="{{URL::to('/api/declineorder/' . $id)}}">
        <Say voice="alice" language="en-AU">
          The order has been declined. Please provide a reason that the order was declined.
          Press 1 for out of stock, 2 for item not on menu, 3 for wrong number, 4 for order too large, 5 for any other reason.
        </Say>
    </Gather>
</Response>
