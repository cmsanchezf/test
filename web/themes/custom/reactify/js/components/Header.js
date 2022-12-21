import React from 'react';
// Define the component using the functional component syntax
const Header = (props) => {
    // Destructure the props to make them easier to use
    const { logoUrl, title, menuItems } = props;
    return (React.createElement("header", null,
        React.createElement("img", { src: logoUrl, alt: title }),
        React.createElement("h1", null, title),
        React.createElement("nav", null, menuItems.map(item => (React.createElement("a", { href: "#" }, item))))));
};
export default Header;
