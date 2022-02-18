# Blog Example

Simple yet full-featured example of GraphQL API.
Models a blogging platform with Stories, Users and hierarchical comments.

## Run local test server

```sh
php -S 192.168.166.168:8081 -t $dir/public/
```

### Try query
```
curl -d '{"query": "query { hello }" }' -H "Content-Type: application/json" http://localhost:8080
```

The response should be:

```json
{
  "data": {
    "hello": "Your graphql-php endpoint is ready! Use a GraphQL client to explore the schema."
  }
}
```

## Explore the Schema

The most convenient way to explore a GraphQL schema is to use a GraphQL client.
We recommend you download and install [Altair](https://altair.sirmuel.design).

Set `http://localhost:8080` as your GraphQL endpoint and try clicking the "Docs" button
to explore the schema definition.

## Running GraphQL Queries

Copy the following query to your GraphQL client and send the request:

```graphql
{
  hello
  world
  viewer {
    ...User
    photo(size: MEDIUM) {
      ...Image
    }
    lastStoryPosted {
      ...Story
      author {
        ...User
      }
      mentions {
        ...Mentions
        ... on Story {
          ...Story
        }
        ... on User {
          ...User
        }
      }
      comments {
        ...Comment
        parent {
          ...Comment
        }
        replies {
          ...Comment
        }
      }
    }
  }
  user(id: "1") {
    ...User
  }
  lastStoryPosted {
    likedBy {
      ...User
    }
    comments {
      ...Comment
    }
  }
  stories(after: "1") {
    id
    body
    comments {
      ...Comment
    }
  }
}

fragment User on User {
  id
  email
  firstName
  lastName
  name
}

fragment Image on Image {
  id
  width
  height
  size
  url
  name
}

fragment Story on Story {
  id
  totalCommentCount
  affordances
  body(format: HTML, maxLength: 10)
  hasViewerLiked
}

fragment Mentions on SearchResult {
  __typename
}

fragment Comment on Comment {
  id
  totalReplyCount
  body
  isAnonymous
}
```

## Run your own query

Use autocomplete (via CTRL+space) to easily create your own query.

Note: GraphQL query requires at least one field per object type (to prevent accidental overfetching).
For example, the following query is invalid in GraphQL:

```graphql
{
    viewer
}
```

### Dig into source code
Now when you tried GraphQL API as a consumer, see how it is implemented by browsing
the source code.
