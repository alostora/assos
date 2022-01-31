import React from "react";
import PropTypes from "prop-types";

const YoutubeEmbed = ({ embedLink }) => (
  <div className="video-responsive">
    <iframe
      width="100%"
      height="480px"
      src={`https://www.youtube.com/embed/${embedLink}`}
      frameBorder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowFullScreen
      title="Embedded youtube"
    />
  </div>
);

YoutubeEmbed.propTypes = {
  embedLink: PropTypes.string.isRequired
};

export default YoutubeEmbed;