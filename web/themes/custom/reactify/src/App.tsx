// app.tsx
import React from 'react';
import ReactDOM, { render } from 'react-dom';

import Header from './components/Header';

interface Props {
  copyright: string;
  socialMediaLinks: {
    url: string;
    name: string;
  }[];
  linkGroups: {
    title: string;
    links: {
      url: string;
    }[];
  }[];
}

const props = {
  copyright: 'Copyright 2022',
  socialMediaLinks: [
    {
      url: 'https://twitter.com/',
      name: 'Twitter',
    },
    {
      url: 'https://facebook.com/',
      name: 'Facebook',
    },
  ],
  linkGroups: [
    {
      title: 'Group 1',
      links: [
        {
          url: 'https://example.com/1',
          text: 'Link 1',
        },
        {
          url: 'https://example.com/2',
          text: 'Link 2',
        },
      ],
    },
    {
      title: 'Group 2',
      links: [
        {
          url: 'https://example.com/3',
          text: 'Link 3',
        },
        {
          url: 'https://example.com/4',
          text: 'Link 4',
        },
      ],
    },
  ],
}

const App: React.FC<{}> = (props) => {
  // renderizar el componente de React en la plantilla de Drupal
  return ReactDOM.render(
    React.createElement(
      "div",
      null,
      React.createElement(Header, {
        title: "My Drupal 9 Theme",
        logoUrl: '',
        menuItems: ['Home', 'About', 'contanct']
      }),
      React.createElement("h1", null, "My App"),
      " "
    ),
    document.getElementById('app')
  );
};

export default App;
