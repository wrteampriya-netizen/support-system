<form method="POST" action="{{ route('chats.send') }}">
    @csrf

    <input type="hidden" name="reciever_id" value="{{ $customer_id }}">

    <input type="text" name="message" placeholder="Type message">

    <button type="submit">Send</button>
</form>