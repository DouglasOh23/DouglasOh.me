function Message() {
    const name = "Douglas Oh";
    if (name)
        return <h1>Hello {name}</h1>;
    return <h1>Hello, this is a message!</h1>; 
}

export default Message;