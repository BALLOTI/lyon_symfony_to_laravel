<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 24/04/17
 * Time: 13:21
 */

namespace ForumBundle\DataFixtures\ORM;


use ForumBundle\Entity\Subject;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSubjectData extends AbstractFixture implements OrderedFixtureInterface
{

    const TOTAL_SUBJECT = 3;

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $subjects = [
            [
                "title" => "Peut-on développer un forum avec Symfony",
                "content" => "Aenean molestie porta urna, non maximus diam egestas vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut tellus magna, consectetur eu magna ut, ultricies mollis tortor. In ut massa tincidunt, blandit nisi a, tempus enim. Morbi sed vehicula lorem. Quisque condimentum, magna vitae aliquet auctor, odio nunc blandit erat, in cursus dui urna quis metus. Quisque vestibulum eros nec dolor dapibus eleifend. Proin vel diam at enim vulputate tincidunt. Nulla tincidunt ligula ullamcorper dui viverra feugiat. Proin eget imperdiet magna. Integer suscipit congue leo, sit amet luctus mi aliquam sed. Praesent dignissim felis nec leo efficitur facilisis.",
            ],
            [
                "title" => "Peut-on développer un forum avec Laravel",
                "content" => "Quisque vestibulum sit amet metus sed auctor. Praesent aliquet hendrerit lacus, a fringilla enim mollis eu. Proin non nibh eu eros porttitor semper. Vestibulum sagittis pretium ligula ut efficitur. Phasellus vel euismod felis. Proin eget odio scelerisque, imperdiet ipsum eget, tincidunt lorem. Integer suscipit mauris sed ex interdum, a pellentesque magna consequat. Donec vel lectus imperdiet, rutrum odio non, ornare ante. Suspendisse interdum sed erat vel faucibus. Sed lobortis dui sed purus maximus imperdiet. Duis consectetur imperdiet elit finibus consequat. Donec eu tristique justo. Curabitur at molestie ipsum, vel porta justo.",
            ],
            [
                "title" => "Ce sont vos besoins qui vont dicter vos choix",
                "content" => "Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris dolor ante, commodo venenatis arcu quis, dignissim porta metus. Proin dignissim, sem ut fringilla condimentum, purus turpis sollicitudin enim, sed tempus mi augue a nisl. Nulla vitae gravida magna, mollis cursus diam. Nullam at eleifend neque. Donec sit amet justo purus. Pellentesque eget finibus libero. Suspendisse quis tortor sollicitudin, pretium turpis vitae, auctor nibh. Integer pharetra dolor ut purus elementum congue. Mauris sed urna dictum, convallis est a, aliquet lacus. Duis elementum cursus ipsum vel eleifend. In sit amet odio sit amet libero dictum vestibulum. Nam varius a arcu eu efficitur.",
            ],
        ];

        foreach ($subjects as $key=>$subject){
            $newSubject = new Subject();
            $newSubject->setTitle($subject["title"]);
            $newSubject->setContent($subject["content"]);
            $newSubject->setUser($this->getReference("user_" . rand(1, LoadUserData::TOTAL_USER)));
            $manager->persist($newSubject);
            $this->setReference("subject_" . ($key + 1), $newSubject);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

}