<?php

namespace AdminBundle\DataFixtures\ORM;

use CommonBundle\Entity\News;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadNewsData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function load(ObjectManager $manager)
    {
        $news1 = new News();
        $news1->setTitle('Начинаем работать с IPv6 в операционной системе FortiOS');
        $news1->setText('Введение и немного теории. 

Происхождение протокола IP версии 6 относится к 1998 году к RFC 2460, который описывает IPv6 как протокол-преемник для 4-ой версии. Данный переход связан с предсказуемым исчерпанием адресного пространства в IPv4. Переход от 32-х битных к 128-ми битным адресам позволил увеличить адресное пространство в IPv6 до предела 2 в 128 степени количества адресов. Однако помимо увеличения адресного пространства, в реализации IPv6 достаточно много нововведений, призванных избавить данный протокол от проблем его предшественника. К данным нововведениям можно отнести – отсутствие broadcast, SLAAC, NDP. ');

        $manager->persist($news1);


        $news2 = new News();
        $news2->setTitle('Игрища с сервером — 3 или openvpn и ipv6');
        $news2->setText('
                    Игрища с сервером — 3 или openvpn и ipv6
                    Сделав очередной openvpn сервер, я задался вопросом: а нафига я его вообще делал? Нет, что бы добираться безопасно до своих ресурсов, это да. Но одна из главных задач — дать клиенту ipv6 в мире ipv4. И именно её он не выполняет. Значит сейчас починим.
                    
                    Самый простой вариант «в лоб» — перевести сервер в бридж режим и пусть клиенты будут представляться хост-машине как еще одни виртуалки. Минус — замучаюсь с безопасностью. Плюс — тупо и надежно.
                    
                    Вариант посложнее — выпилить кусочек ipv6 сети и давать её клиентам. Минус тут один — некоторые клиенты почему-то желают видеть у себя /64 и никак иначе. А у меня всего одна /64. Нет, можно получить еще через любого туннельного брокера, но не хочу.
                    
                    Значит вариант остается один: взять приватную ipv6 подсеть и сделать раздачу из него. Для выбора сетки мы можем брать все что нам понравится, главное что бы первый байт адреса был fd. Вот тут можно даже побаловаться, просто обновляя страничку.
                    
                    Я возьму для своих крамольных целей сеть fdab:cdef:1234:5678::/64
                    
                    Почитав маны, добавляю следующие строчки в конфиг сервера
                    
                    server-ipv6 fdab:cdef:1234:5678::/64
                    tun-ipv6
                    push tun-ipv6
                    
                    И перезагружаю сервер

                    systemctl restart openvpn@server.service');
        $manager->persist($news2);

        $news3 = new News();
        $news3->setTitle('IPv6 под прицелом');
        $news3->setText('Казалось бы, зачем сейчас вообще вспоминать про IPv6? Ведь несмотря на то, что последние блоки IPv4-адресов были розданы региональным регистраторам, интернет работает без каких-либо изменений. Дело в том, что IPv6 впервые появился в 1995 году, а полностью его заголовок описали в RFC в 1998 году. Почему это важно? Да по той причине, что разрабатывался он без учета угроз, с той же доверительной схемой, что и IPv4. И в процессе разработки стояли задачи сделать более быстрый протокол и с большим количеством адресов, а не более безопасный и защищенный.
                Кратко про темпы роста
                Если изучить графики, которые предоставляет региональный регистратор IP-адресов и автономных систем, то можно обнаружить, что по состоянию на первое сентября 2014 года количество зарегистрированных IPv6 автономных систем уже перевалило за 20%. На первый взгляд, это серьезная цифра. Но если брать во внимание только реальное количество IPv6-трафика в мире, то сейчас это около 6% от всего мирового интернет-трафика, хотя буквально три года назад было всего 0,5%. ');

        $manager->persist($news3);

        $news4 = new News();
        $news4->setTitle('Самая актуальная версия протокола');
        $news4->setText('Протокол IP имеет несколько версий, самой актуальной из которых, на сегодняшний день, является шестая. Ее и используют для подключения к интернету. Большой популярностью также пользуется четвертая версия. Однако, IPv6 имеет ряд преимуществ. Самое главное – более широкое адресное пространство – 2128 штук. На одном сервере может применяться как IPv6 так и IPv4 одновременно. Если у вас возникнет необходимость полностью перейти на свежую версию протокола, то данный материал будет для вас полезным. IPv4 останется активным только для локального хоста. От этого зависит корректная работа некоторых важных программ.
                Временное отключение IPv4
                Чтобы это сделать, можно внести правки в файл /etc/resolv.conf, произвести настройку применения DNS-серверов IPv6 (в случае активации версии протокола), а также удалить правило, ответственно за поддержку четвертой версии. До следующей перезагрузки сервера, изменения будут оставаться в силе. Для корректировки файла наберите:
                sudo nano /etc/resolv.conf
                Параметр nameservers отвечает за установку адресов IPv4. Вам предстоит изменить его значение на IPv6. Если вы хотите настроить правила на имена сервера IPv6 Google пропишите:
                nameserver 2001:4860:4860::8844 
                nameserver 2001:4860:4860::8888 
                nameserver 209.244.0.3
                Теперь сохраните изменения, после чего файл можно закрыть. Следующий этап – определить префикс IPv4 адресов, а также CIDR-маршрутизации:');

        $manager->persist($news4);

        $news5= new News();
        $news5->setTitle('Less Is More - Why The IPv6 Switch Is Missing');
        $news5->setText('At Cloudflare we believe in being good to the Internet and good to our customers. By moving on from the legacy world of IPv4-only to the modern-day world where IPv4 and IPv6 are treated equally, we believe we are doing exactly that.
                    "No matter what happens in life, be good to people. Being good to people is a wonderful legacy to leave behind." - Taylor Swift (whose website has been IPv6 enabled for many many years)
                    Starting today with free domains, IPv6 is no longer something you can toggle on and off, it’s always just on.
                        Cloudflare has always been a gateway for visitors on IPv6 connections to access sites and applications hosted on legacy IPv4-only infrastructure. Connections to Cloudflare are terminated on either IP version and then proxied to the backend over whichever IP version the backend infrastructure can accept.
                    ');
        $manager->persist($news5);

        $news6 = new News();
        $news6->setTitle('An IPv6 Campus of the Future');
        $news6->setText('IPv6 as a protocol has been known for a while, but enterprises are beginning to understand the ways in which it can help them achieve their goals, improve efficiency and gain functionality that were hitherto unavailable.

When the IPv4 to IPv6 transition first took place, some Internet-scale companies enthusiastically adopted the technology. They built out their data centers as IPv6-only networks understanding the impending exhaustion of IPv4 addresses. Most other companies attempted to manage the transition by simply migrating from native IPv4 to a dual stack network for IPv6 compatibility. This, however, neither saved IPv4 addresses nor improved features and applications over IPv6.  The logical next step for those companies and indeed the industry, in general, is to implement entire campuses as IPv6-only networks. The advantages include avoiding the maintenance of two protocol stacks, reduced OPEX, and, chiefly, no more dependency on IPv4 address. The IPv6 network is cleaner, faster and more secure thanks to a protocol redesigned to embrace encryption, favor targeted multicast over expensive broadcast communication and remove variable length subnets from routing.

Cisco has been one of the early pioneers in this space. From an implementation and adoption standpoint, we have taken it upon ourselves to start building an IPv6-only campus to demonstrate to our customers not just the criticality of this technology but also how exactly to manage the transition seamlessly.');
        $manager->persist($news6);

        $news7 = new News();
        $news7->setTitle('IPv6 Enables Global Mobile IoT Innovation and Proliferation');
        $news7->setText('Advanced Addressing Scheme Securely Connects Billions of Devices and Things

Digitization and automation is now a familiar feature in many homes. Mobile connectivity is not just for phones anymore. Today, we have lots of things that generate data or environments that we want to control (locally or remotely). And our access point for control is not limited to our smartphones – televisions, tablets, smartwatches, health monitors and even kitchen appliances can all serve as “digital control points.” Ubiquitous connectivity and control are fundamental elements of the Internet of Things (IoT) value proposition. The challenge of delivering seamless user experiences through communications between all of our devices and things that we want to control is becoming more broad and complex.   According to the 2017 Cisco Mobile Visual Networking Index (VNI), there will be nearly 12 billion global mobile-connected devices and machine-to-machine (M2M) connections by 2021, approximately 1.5 per capita. Globally, mobile networks will support about 4 billion new mobile-connected devices and connections from 2016 to 2021.');
        $manager->persist($news7);

        $news8 = new News();
        $news8->setTitle('Bringing Segment Routing and IPv6 together');
        $news8->setText('You may be pretty familiar with Segment Routing and I bet you’re likely tying it to MPLS as the industry at large has been mainly focused on driving awareness and adoption of MPLS Segment Routing.

But did you know Segment Routing could work in a native IPv6 environment? Sounds interesting to you?

Let’s first go back to some IPv6 basics.

IPv6 packet header has been designed from its inception to offer flexibility by augmenting the IPv6 header with a set of instructions, called “Extension Header”. There are six different types of Extension Header as per RFC 2460:');
        $manager->persist($news8);


        $news9 = new News();
        $news9->setTitle('Government’s Journey to IPv6');
        $news9->setText('Last month, I had the opportunity to attend and present at the 2015 North American IPv6 Summit. Several hundred IPv6 experts and networking professionals attended from across the country to discuss the IPv6 adoption, hear about the latest IPv6 research and learn what others are doing to prepare for the transition to IPv6.

To refresh, IPv6 is the next-generation Internet Protocol (IP), the communications protocol that provides identification for computers on networks and allows computers to talk to each other. The existing Internet Protocol, IPv4, has a finite number of IP addresses, limiting the number of devices that can be given a new address. In fact, the free pool held by the Internet Assigned Numbers Authority (IANA) was depleted in 2011 and the American Registry of Internet Numbers (ARIN) has less than 3.5 million IP addresses left, a supply so small it could be completely exhausted by June of this year. IPv6’s large number of new IP addresses make it a foundational building block for the future of the Internet, especially as increasingly more devices become connected as part of the Internet of Things (IoT).');
        $manager->persist($news9);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        return $this->container = $container;
    }
}