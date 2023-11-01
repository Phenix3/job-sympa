import React, { useState, useCallback } from 'react';
// import { unmountComponentAtNode } from 'react-dom';
import { createRoot } from 'react-dom/client';
import retargetEvents from 'react-shadow-dom-retarget-events';
import axios from 'axios';

const BookmarkButton = (props) => {
	// console.log('Props', props);
    const [bookmarked, setBookmarked] = useState(props.bookmarked);
	const [bookmark, setBookmark] = useState(null);

	const handleClick = useCallback(e => {
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
			// console.log('Bookmark ', bookmark);
			deleteBookmark(bookmark);
		}
	}, [bookmark, bookmarked]);

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

	let classNames = "";
	let label = '';
	const icon = <i className="lni lni-heart-filled snackbar-wishlist"></i>;

	if(props.icon == true) {
		classNames = 'p-3 d-flex border circle  align-items-center justify-content-center bg-white text-';
	} else {
		label = 'Save This Job';
		classNames = 'btn btn-sm rounded fs-sm ft-medium mr-2 text-' + classNames;
	}

	classNames = bookmarked ? classNames + "danger" : classNames + "gray";

	return <button type="button" className={classNames} onClick={handleClick}>
			{icon} {label}
		</button>;
}

export class BookmarkButtonElement extends HTMLElement {


	constructor() {
		super();
        // this.shadow = this.attachShadow({ mode: 'open' });
	}

    static get observedAttributes() {
	    return ['data-bookmarked', 'data-job', 'data-user', 'icon', 'data-route', 'id'];
	}

    connectedCallback() {
        // console.log('BookmarkButtonElement', this);
        this.renderElement();
    }

    renderElement() {
    	const { bookmarked, job, user, icon, route } = this.dataset;

        // this.mountPoint = document.createElement('span');
        // this.shadow.appendChild(this.mountPoint);

        this.root = null;
        try {
        	this.root = createRoot(this);
        	this.root.render(<BookmarkButton bookmarked={bookmarked} job={job} user={user} icon={icon} route={route} />);
        } catch (e) {
        	console.log('Error createRoot', e);
        }
        // retargetEvents(this.shadow);
    }

    disconnectedCallback() {
        console.log('UnmountComponent', this);
        this.root.unmount();
    }

	attributeChangedCallback(name, oldValue, newValue) {
	    // console.log(`The attribute ${name} was updated from ${oldValue} to ${newValue}`);
	    this.renderElement();
	}
}

export default BookmarkButton;
