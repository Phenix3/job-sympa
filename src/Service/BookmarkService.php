<?php

namespace App\Service;

use App\Entity\Bookmark;
use App\Entity\Job\Job;
use App\Entity\User\Candidate;
use App\Entity\User\CandidateCvs;
use App\Entity\User\CvsBookmark;
use App\Entity\User\JobBookmark;
use App\Event\User\BookmarkCreatedEvent;
use App\Event\User\BookmarkDeletedEvent;
use App\Repository\User\JobBookmarkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class BookmarkService
{
    public function __construct(private EntityManagerInterface $manager, private EventDispatcherInterface $eventDispatcher)
    {}

    public function create(Bookmark $bookmark)
    {
        /** @var JobBookmarkRepository $repo */
        $repo = $this->manager->getRepository(get_class($bookmark));
        $repo->add($bookmark, true);
        $this->eventDispatcher->dispatch(new BookmarkCreatedEvent($bookmark));
    }

    public function remove(Bookmark $bookmark)
    {
        /** @var JobBookmarkRepository $repo */
        $repo = $this->manager->getRepository(get_class($bookmark));
        $repo->remove($bookmark, true);
        $this->eventDispatcher->dispatch(new BookmarkDeletedEvent($bookmark));
    }

    public function getJobBookmarks(Candidate $candidate): mixed
    {
        /** @var JobBookmarkRepository $repo */
        $repo = $this->manager->getRepository(JobBookmark::class);
        return $repo->findAllForCandidateQuery($candidate);
    }

    public function toggleBookmark(UserInterface $user, ?Job $job = null, ?CandidateCvs $candidateCvs = null)
    {
        if ($job) {
            if (!$job->isBookmarkedByUser($user)) {
                $bookmark = (new JobBookmark())
                    ->setJob($job)
                    ->setUser($user)
                    ;
                $this->create($bookmark);
                return true;
            } else {
                $bookmarkRepository = $this->manager->getRepository(JobBookmark::class);
                $bookmark = $bookmarkRepository->findOneBy(['job' => $job, 'user' => $user]);// $jobBookmarkRepository->findForCandidateQuery($user, $job)->getOneOrNullResult();
                $this->remove($bookmark);
                return $this->removeBookmark($bookmark);;
            }
        } elseif ($candidateCvs) {
            if (!$candidateCvs->isBookmarkedByUser($user)) {
                $bookmark = (new CvsBookmark())
                    ->setCv($candidateCvs)
                    ->setUser($user)
                    ;
                $this->create($bookmark);
                return true;
            } else {
                $bookmarkRepository = $this->manager->getRepository(CvsBookmark::class);
                $bookmark = $bookmarkRepository->findOneBy(['cv' => $candidateCvs, 'user' => $user]);// $jobBookmarkRepository->findForCandidateQuery($user, $job)->getOneOrNullResult();
                $this->remove($bookmark);
                return $this->removeBookmark($bookmark);;
            }
        }

    }

    private function removeBookmark(Bookmark $bookmark): bool
    {
        $bookmarkRepository = $this->manager->getRepository(Bookmark::class);
        $bookmarkRepository->remove($bookmark, true);// $jobBookmarkRepository->findForCandidateQuery($user, $job)->getOneOrNullResult();
        return false;
    }
}