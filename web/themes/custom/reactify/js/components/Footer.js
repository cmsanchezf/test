import React from 'react';
// Define the component using the functional component syntax
const Footer = (props) => {
    // Destructure the props to make them easier to use
    const { copyright, socialMediaLinks, linkGroups } = props;
    return (React.createElement("footer", null,
        React.createElement("p", null, copyright),
        linkGroups.map(group => (React.createElement("section", null,
            React.createElement("h2", null, group.title),
            React.createElement("nav", null, group.links.map(link => (React.createElement("a", { href: link.url }, link.text))))))),
        React.createElement("nav", null, socialMediaLinks.map(link => (React.createElement("a", { href: link.url }, link.name))))));
};
export default Footer;
