import React from 'react';

import { FooterProps } from '../interfaces/IFooterProps';

// Define the component using the functional component syntax
const Footer: React.FC<FooterProps> = (props: FooterProps) => {
  // Destructure the props to make them easier to use
  const { copyright, socialMediaLinks, linkGroups } = props;

  return (
    <footer>
      <p>{copyright}</p>
      {linkGroups.map(group => (
        <section>
          <h2>{group.title}</h2>
          <nav>
            {group.links.map(link => (
              <a href={link.url}>{link.text}</a>
            ))}
          </nav>
        </section>
      ))}
      <nav>
        {socialMediaLinks.map(link => (
          <a href={link.url}>{link.name}</a>
        ))}
      </nav>
    </footer>
  );
};

export default Footer;