// Define the interface for the component's props
export interface FooterProps {
    // The copyright notice to display in the footer
    copyright: string;
    // The array of social media links to display in the footer
    socialMediaLinks: {
      // The URL of the social media link
      url: string;
      // The name of the social media platform
      name: string;
    }[];
    // The array of link groups to display in the footer
    linkGroups: {
      // The title of the link group
      title: string;
      // The array of links in the group
      links: {
        // The URL of the link
        url: string;
        // The text of the link
        text: string;
      }[];
    }[];
  }
  