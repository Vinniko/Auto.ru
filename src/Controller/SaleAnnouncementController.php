<?php

namespace App\Controller;

use App\DTOClasses\ExceptionMessage;
use App\Entity\Auto;
use App\Entity\Country;
use App\Entity\SaleAnnouncement;
use App\Repository\CountryRepository;
use App\Repository\SaleAnnouncementRepository;
use DateTime;
use Doctrine\DBAL\Exception\ConnectionException;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

/**
 * Class SaleAnnouncementController
 * @package App\Controller
 * @Route("/sale")
 */
class SaleAnnouncementController extends AbstractController
{
    private $sale_announcement_creating_succesful = 'Объявление о продаже успешно создано.';
    private $sale_announcement_updating_succesful = 'Объявление о продаже успешно обновлено.';

    /**
     * @Route("/index",  methods={"GET"}, name="sale_announcement_index")
     */
    public function index(SaleAnnouncementRepository $saleAnnouncementRepository, Request $request): Response
    {
        $params = $request->query->all();
        $error = null;
        $message = null;
        $sale_announcements = null;
        $mark = empty($params['mark']) ? null : $params['mark'];
        $start_date = empty($params['start_date']) ? null
            : DateTime::createFromFormat('Y-m-d', $params['start_date']);
        $end_date = empty($params['end_date']) ? null
            : DateTime::createFromFormat('Y-m-d', $params['end_date']);
        $country = empty($params['country']) ? null : $params['country'];
        $start_price = empty($params['start_price']) ? null : $params['start_price'];
        $end_price = empty($params['end_price']) ? null : $params['end_price'];

        try {
            $sale_announcements = $saleAnnouncementRepository->filter($mark, $start_date, $end_date, $country,
                $start_price, $end_price);
        } catch (TableNotFoundException $exception) {
            $error = ExceptionMessage::DATABASE_TABLE_EXISTS_EXCEPTION;
        } catch (ConnectionException $exception) {
            $error = ExceptionMessage::DATABASE_CONNECTION_EXCEPTION;
        } catch (Throwable $exception) {
            $error = ExceptionMessage::UNDEFINED_EXCEPTION;
        }

        return $this->render('pages/sale_announcement/index.html.twig', [
            'sales' => $sale_announcements,
            'error' => $error,
            'message' => $message,
            'mark' => $mark,
            'start_date' => $start_date ? $start_date->format('Y-m-d') : null,
            'end_date' => $end_date ? $end_date->format('Y-m-d') : null,
            'country' => $country,
            'start_price' => $start_price,
            'end_price' => $end_price,
        ]);
    }

    /**
     * @Route("/get/{id}",  methods={"GET"}, defaults={"id": 0}, name="sale_announcement_get")
     */
    public function show(SaleAnnouncementRepository $saleAnnouncementRepository, Request $request, int $id): Response
    {
        $error = null;
        $message = null;
        $sale_announcement = null;

        try {
            $sale_announcement = $saleAnnouncementRepository->findById($id);
        } catch (TableNotFoundException $exception) {
            $error = ExceptionMessage::DATABASE_TABLE_EXISTS_EXCEPTION;
        } catch (ConnectionException $exception) {
            $error = ExceptionMessage::DATABASE_CONNECTION_EXCEPTION;
        } catch (Throwable $exception) {
            $error = ExceptionMessage::UNDEFINED_EXCEPTION;
        }

        return $this->render('pages/sale_announcement/sale.html.twig', [
            'sale' => $sale_announcement,
            'error' => $error,
            'message' => $message,
        ]);
    }

    /**
     * @Route("/store",  methods={"POST"}, name="sale_announcement_store")
     */
    public function store(
        SaleAnnouncementRepository $saleAnnouncementRepository,
        Request $request,
        CountryRepository $countryRepository,
        ValidatorInterface $validator
    ): Response {
        $params = $request->request->all();
        $message = null;
        $error = null;

        try {
            $countries = $countryRepository->findBy([
                'title' => htmlspecialchars($params['country']),
            ], null, 1);

            if (count($countries) != 0) {
                $country = $countries[0];
            } else {
                $country = new Country();
                $country->setTitle(htmlspecialchars($params['country']));
            }

            $auto = new Auto();
            $auto->setMark(htmlspecialchars($params['mark']));
            $auto->setBuildYear(new DateTime($params['build_date']));
            $auto->setCountry($country);
            $sale_announcement = new SaleAnnouncement();
            $sale_announcement->setPrice($params['price']);
            $sale_announcement->setAuto($auto);

            $this->getDoctrine()->getManager()->persist($country);
            $this->getDoctrine()->getManager()->persist($auto);
            $this->getDoctrine()->getManager()->persist($sale_announcement);

            $this->getDoctrine()->getManager()->flush();
            $message = $this->sale_announcement_creating_succesful;
        } catch (TableNotFoundException $exception) {
            $error = ExceptionMessage::DATABASE_TABLE_EXISTS_EXCEPTION;
        } catch (ConnectionException $exception) {
            $error = ExceptionMessage::DATABASE_CONNECTION_EXCEPTION;
        } catch (Throwable $exception) {
            $error = ExceptionMessage::UNDEFINED_EXCEPTION;
        }

        return $this->create($message, $error);
    }

    /**
     * @Route("/create",  methods={"GET"}, name="sale_announcement_create")
     */
    public function create(?string $message, ?string $error): Response
    {
        return $this->render('pages/sale_announcement/create.html.twig', [
            'message' => $message,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/edit",  methods={"POST"}, name="sale_announcement_edit")
     */
    public function edit(
        SaleAnnouncementRepository $announcementRepository,
        CountryRepository $countryRepository,
        ValidatorInterface $validator,
        Request $request
    ): Response {
        $params = $request->request->all();
        $message = null;
        $error = null;

        try {
            $sale_announcement = $announcementRepository->findById($params['id']);
            $auto = $sale_announcement->getAuto();
            $country = $auto->getCountry();

            if ($country->getTitle() != htmlspecialchars($params['country'])) {
                $country->removeAuto($auto);
                $this->getDoctrine()->getManager()->persist($country);
                $countries = $countryRepository->findBy([
                    'title' => htmlspecialchars($params['country']),
                ], null, 1);

                if (count($countries) != 0) {
                    $country = $countries[0];
                } else {
                    $country = new Country();
                    $country->setTitle(htmlspecialchars($params['country']));
                }

                $auto->setCountry($country);

                $this->getDoctrine()->getManager()->persist($country);
                $this->getDoctrine()->getManager()->persist($auto);
            }

            $auto->setMark(htmlspecialchars($params['mark']));
            $auto->setBuildYear(new DateTime($params['build_date']));
            $sale_announcement->setPrice($params['price']);
            $sale_announcement->setAuto($auto);

            $this->getDoctrine()->getManager()->flush();
            $message = $this->sale_announcement_updating_succesful;
        } catch (TableNotFoundException $exception) {
            $error = ExceptionMessage::DATABASE_TABLE_EXISTS_EXCEPTION;
        } catch (ConnectionException $exception) {
            $error = ExceptionMessage::DATABASE_CONNECTION_EXCEPTION;
        } catch (Throwable $exception) {
            $error = ExceptionMessage::UNDEFINED_EXCEPTION;
        }

        return $this->update($announcementRepository, $params['id'], $message,
            $error);
    }

    /**
     * @Route("/update/{id}",  methods={"GET"}, defaults={"id": 0}, name="sale_announcement_update")
     */
    public function update(
        SaleAnnouncementRepository $saleAnnouncementRepository,
        int $id,
        ?string $message,
        ?string $error
    ): Response {
        $sale_announcement = null;

        try {
            $sale_announcement = $saleAnnouncementRepository->findById($id);
        } catch (TableNotFoundException $exception) {
            $error = ExceptionMessage::DATABASE_TABLE_EXISTS_EXCEPTION;
        } catch (ConnectionException $exception) {
            $error = ExceptionMessage::DATABASE_CONNECTION_EXCEPTION;
        } catch (Throwable $exception) {
            $error = ExceptionMessage::UNDEFINED_EXCEPTION;
        }

        return $this->render('pages/sale_announcement/update.html.twig', [
            'sale' => $sale_announcement,
            'message' => $message,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/delete",  methods={"POST"}, defaults={"id": 0}, name="sale_announcement_delete")
     */
    public function delete(
        SaleAnnouncementRepository $saleAnnouncementRepository,
        Request $request,
        ?string $message,
        ?string $error
    ): Response {

        try {
            $sale_announcement = $saleAnnouncementRepository->findById($request->request->all()['id']);
            $this->getDoctrine()->getManager()->remove($sale_announcement);
            $this->getDoctrine()->getManager()->flush();
        } catch (TableNotFoundException $exception) {
            $error = ExceptionMessage::DATABASE_TABLE_EXISTS_EXCEPTION;
        } catch (ConnectionException $exception) {
            $error = ExceptionMessage::DATABASE_CONNECTION_EXCEPTION;
        } catch (Throwable $exception) {
            $error = ExceptionMessage::UNDEFINED_EXCEPTION;
        }

        return $this->redirect('/sale/index');
    }
}
