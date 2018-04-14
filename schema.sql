CREATE TABLE tweets (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(100),
  text varchar(510),
  image_path varchar(255),
  favorite_count int(11),
  retweet_count int(11),
  latitude double,
  longitude double,
  tweeted_at varchar(100),
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
  updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp,
  PRIMARY KEY(id)
)