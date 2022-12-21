import React from 'react';

import { HeaderProps } from '../interfaces/IHeaderProps';

// Define the component using the functional component syntax
const Header: React.FC<HeaderProps> = (props: HeaderProps) => {
  // Destructure the props to make them easier to use
  const { logoUrl, title, menuItems } = props;

  return (
    <header>
      <img src={logoUrl} alt={title} />
      <h1>{title}</h1>
      <nav>
        {menuItems.map(item => (
          <a href="#">{item}</a>
        ))}
      </nav>
    </header>
  );
};

export default Header;