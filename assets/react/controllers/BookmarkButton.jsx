import React, {useState} from 'react';
import axios from 'axios';

const BookmarkButton = (props) => {
    const [bookmarked, setBookmarked] = useState(props.bookmarked);
	const [bookmark, setBookmark] = useState(null);

	const handleClick = (e) => {
		e.preventDefault();
		e.stopPropagation();
		setBookmarked(bookmarked => !bookmarked);
		if(!bookmarked) {
			createBookmark();
		} else {
			if(!bookmark) {
				loadBookmark();
				return;
			}
			console.log('Bookmark ', bookmark);
			deleteBookmark(bookmark);
		}
	}

	const createBookmark = () => {
		axios.post('/api/graphql', {
				query: `
					mutation {
					  createJobBookmark(input: {job: "/api/jobs/${props.job}", user: "/api/candidates/${props.user}"}) {
					    jobBookmark {
					      id
					      rating
					      job {
					      	id
					      }
					      user {
					      	id
					      }
					    }
					  }
					}
				`
			}).then(response => {
				setBookmark(response.data.data.createJobBookmark.jobBookmark);
			}).catch(error => console.log(error));
	}

	const loadBookmark = () => {
		axios.post('/api/graphql', {
			query: `
				{
				  jobBookmarks(job: "/api/jobs/${props.job}", user: "/api/candidates/${props.user}") {
				    edges {
				      node {
				        id
				        rating
				        user {
				          id
				          email
				          username
				        }
				        job {
				          id
				          title
				        }
				      }
				    }
				    totalCount
				  }
				}
			`
		}).then(response => {
			const data = response.data.data.jobBookmarks;
			setBookmark(bookmark => data.edges[0].node);
			deleteBookmark(data.edges[0].node);
		})
		.catch(error => console.log(error));
	}

	const deleteBookmark = (data) => {
		axios.post('/api/graphql', { 
			query: `
					mutation {
					  deleteJobBookmark(input: {id: "${data.id}"}) {
					    jobBookmark {
					      id
					    }
					  }
					}
				`
		}).then(response => {
			console.log(response);
		}).catch(error => console.log(error));
	}
	let color = "p-3 border circle d-flex align-items-center justify-content-center bg-white text-";
	color = bookmarked ? color + "danger" : color + "gray";

	return <button type="button" className={color} onClick={handleClick}>
			<i className="lni lni-heart-filled position-absolute snackbar-wishlist"></i>
		</button>;
}

export default BookmarkButton;
